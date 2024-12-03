<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function index()
    {
        $marcas = Marca::all();
        return view('marcas.index', compact('marcas'));
    }

    public function create()
    {
        return view('marcas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:marcas|max:255',
        ]);

        Marca::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.marcas.index')->with('success', 'Marca creada correctamente');
    }

    public function edit($id)
    {
        $marca = Marca::findOrFail($id);
        return view('marcas.edit', compact('marca'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:marcas,name,' . $id . '|max:255',
        ]);

        $marca = Marca::findOrFail($id);
        $marca->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.marcas.index')->with('success', 'Marca actualizada correctamente');
    }

    public function destroy($id)
    {
        $marca = Marca::findOrFail($id);
        $marca->delete();

        return redirect()->route('admin.marcas.index')->with('success', 'Marca eliminada correctamente');
    }
}
