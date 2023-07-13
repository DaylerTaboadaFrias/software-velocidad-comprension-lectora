<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('category.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        //Category::findOrFail($request->input('category_id'));

        $category = new Category();
        $category->nombre = $request->input('name');
        //$category->imagen=$nombreArchivo;
        $category->save();
        if ($request->hasFile('img')) {
            $archivo = $request->file('img');
            $fechaActual = now()->format('YmdHis');
            $nombreArchivo = $fechaActual . '_' . $archivo->getClientOriginalName();
            $validated['img'] = $nombreArchivo;
            $category->imagen = $nombreArchivo;
            $category->save();
            //$rutaArchivo = Storage::disk('public')->putFileAs('archivos', $archivo, $nombreArchivo);
            $request->file('img')->move('images/', $nombreArchivo);
        }
        return redirect()->route('category.index');

    }
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', ['category' => $category]);
    }
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->nombre = $request->input('name');
        $category->update();
        if ($request->hasFile('img')) {
            $archivo = $request->file('img');
            $fechaActual = now()->format('YmdHis');
            $nombreArchivo = $fechaActual . '_' . $archivo->getClientOriginalName();
            $validated['img'] = $nombreArchivo;
            $category->imagen = $nombreArchivo;
            $category->update();
            //$rutaArchivo = Storage::disk('public')->putFileAs('archivos', $archivo, $nombreArchivo);
            if ($category->imagen != null) {
                File::delete(app_path() . '/images/' . $category->imagen);
            }
            $request->file('img')->move('images/', $nombreArchivo);
        }
        return redirect()->route('category.index');
    }
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if ($category->imagen != null) {
            File::delete(app_path() . '/images/' . $category->imagen);
        }
        $category->delete();
        return redirect()->route('category.index');
    }

}
