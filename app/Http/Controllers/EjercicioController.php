<?php

namespace App\Http\Controllers;

use App\Models\Ejercicio;
use App\Models\Tipo;
use App\Models\Nivel;
use App\Models\Lectura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class EjercicioController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$niveles = Nivel::all();
        //$tipos = Tipo::all();
        $ejercicios = Ejercicio::all();
        //$lecturas = Lectura::all();

        return view('ejercicios.index', compact('ejercicios' /*, 'niveles', 'tipos', 'lecturas'*/));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $niveles = Nivel::all();
        $tipos = Tipo::all();

        return view('ejercicios.modal-create', compact('niveles', 'tipos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recomendaciones' => 'required|string',
            'velocidad' => 'required|numeric',
            'lecturas' => 'required|array',
            'palabrasClave' => 'required|array',
            'lecturas.*' => 'required|string',
            'palabrasClave.*' => 'required|string',
        ]);

        // Crear un nuevo usuario y guardar los datos
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ejercicios = new Ejercicio;
        $ejercicios->recomendaciones = $request->input('recomendaciones');
        $ejercicios->velocidad = $request->input('velocidad');
        $ejercicios->nivel_id = $request->input('nivel_id');
        $ejercicios->tipo_ejercicio_id = $request->input('tipo_id');
        $ejercicios->save();

        $lecturas = [];
        foreach ($request->input('lecturas') as $index => $parrafo) {
            $lectura = new Lectura;
            $lectura->parrafo = $parrafo;
            $lectura->palabras_clave = $request->input('palabrasClave')[$index];
            $lectura->id_ejercicio = $ejercicios->id;
            $lectura->save();
            $lecturas[] = $lectura;
        }

        return redirect()->route('ejercicios.index')->with('success', 'Ejercicio creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ejercicio $ejercicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ejercicio = Ejercicio::find($id);
        $niveles = Nivel::all();
        $tipos = Tipo::all();
        $lecturas = $ejercicio->lectura()->get();

        return view('ejercicios.modal-info', compact('ejercicio', 'niveles', 'tipos', 'lecturas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $ejercicios = Ejercicio::find($id);

        $validator = Validator::make($request->all(), [
            'recomendaciones' => 'required|string',
            // 'puntuacion' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            //'puntuacion' => 'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
            //décimas obligatoria
            'velocidad' => 'required|numeric',
            'lecturas' => 'required|array',
            'palabrasClave' => 'required|array',
            'lecturas.*' => 'required|string',
            'palabrasClave.*' => 'required|string',
        ]);

        // Crear un nuevo usuario y guardar los datos
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ejercicios->recomendaciones = $request->input('recomendaciones');
        //$ejercicios->puntuacion = $request->input('puntuacion');
        $ejercicios->velocidad = $request->input('velocidad');
        $ejercicios->nivel_id = $request->input('nivel_id');
        $ejercicios->tipo_ejercicio_id = $request->input('tipo_id');

        $ejercicios->update();

        $lecturas = Lectura::where('id_ejercicio', $id)->get();
        foreach ($lecturas as $lectura) {
            $lectura->delete();
        }

        foreach ($request->input('lecturas') as $index => $parrafo) {
            $lectura = new Lectura;
            $lectura->parrafo = $parrafo;
            $lectura->palabras_clave = $request->input('palabrasClave')[$index];
            $lectura->id_ejercicio = $ejercicios->id;
            $lectura->save();
        }

        return redirect()->route('ejercicios.index')->with('success', 'Ejercicio modificado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lecturas = Lectura::where('id_ejercicio', $id)->get();

        foreach ($lecturas as $lectura) {
            $lectura->delete();
        }

        $ejercicios = Ejercicio::find($id);
        $ejercicios->delete();

        return redirect()->route('ejercicios.index');
    }
}
