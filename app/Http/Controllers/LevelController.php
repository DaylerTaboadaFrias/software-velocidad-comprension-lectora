<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::with('category')->get();
        return view('level.index', ['levels' => $levels]);
    }
    public function create()
    {
        $categories = Category::all();

        return view('level.create', ['categories' => $categories]);
    }
    public function store(Request $request)
    {
        //Category::findOrFail($request->input('categoria_id'));

        $level = new Level();
        $level->nombre = $request->input('name');
        $level->descripcion = $request->input('description');
        $level->categoria_id = $request->input('categoria_id');
        $level->save();
        if ($request->hasFile('img')) {
            $archivo = $request->file('img');
            $fechaActual = now()->format('YmdHis');
            $nombreArchivo = $fechaActual . '_' . $archivo->getClientOriginalName();
            $validated['img'] = $nombreArchivo;
            $level->imagen = $nombreArchivo;
            $level->save();
            //$rutaArchivo = Storage::disk('public')->putFileAs('archivos', $archivo, $nombreArchivo);
            $request->file('img')->move('images/', $nombreArchivo);
        }
        return redirect()->route('level.index');
    }
    public function edit($id)
    {
        $level = Level::findOrFail($id);
        $categories = Category::all();

        return view('level.edit', ['level' => $level, 'categories' => $categories]);
    }
    public function update(Request $request, $id)
    {

        Category::findOrFail($request->input('categoria_id'));

        $level = level::findOrFail($id);

        $level->nombre = $request->input('name');
        $level->descripcion = $request->input('description');
        $level->categoria_id = $request->input('categoria_id');
        $level->update();
        if ($request->hasFile('img')) {
            $archivo = $request->file('img');
            $fechaActual = now()->format('YmdHis');
            $nombreArchivo = $fechaActual . '_' . $archivo->getClientOriginalName();
            $validated['img'] = $nombreArchivo;
            $level->imagen = $nombreArchivo;
            $level->update();
            //$rutaArchivo = Storage::disk('public')->putFileAs('archivos', $archivo, $nombreArchivo);
            if ($level->imagen != null) {
                File::delete(app_path() . '/images/' . $level->imagen);
            }
            $request->file('img')->move('images/', $nombreArchivo);
        }
        return redirect()->route('level.index');
    }

    public function destroy($id)
    {
        $level = Level::findOrFail($id);
        if ($level->imagen != null) {
            File::delete(app_path() . '/images/' . $level->imagen);
        }
        $level->delete();
        return redirect()->route('level.index');
    }

}
