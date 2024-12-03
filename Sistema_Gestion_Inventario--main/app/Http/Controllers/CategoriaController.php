<?php

    namespace App\Http\Controllers;

    use App\Models\Categoria;
    use Illuminate\Http\Request;

    class CategoriaController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $categorias = Categoria::all();
            return view(' categorias.index', compact('categorias'));
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            return view('categorias.create');
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|unique:categorias,name|max:255',
                'descripcion' => 'nullable|string|',
            ]);

            Categoria::create([
                'name' => $request->name,
                'descripcion' => $request->descripcion,
            ]);

            return redirect()->route('admin.categorias.index')
                ->with('success', 'Categoría creada con éxito.');
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(Categoria $categoria)
        {
            return view('categorias.edit', compact('categoria'));
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, Categoria $categoria)
        {
            $request->validate([
                'name' => 'required|unique:categorias,name,' . $categoria->id . '|max:255',
                'descripcion' => 'nullable|string',
            ]);

            $categoria->update([
                'name' => $request->name,
                'descripcion' => $request->descripcion,
            ]);

            return redirect()->route('admin.categorias.index')->with('success', 'Categoría actualizada con éxito.');
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Categoria $categoria)
        {
            try {
                $categoria->delete();
                return redirect()->route('admin.categorias.index')
                    ->with('success', 'Categoría eliminada con éxito.');
            } catch (\Exception $e) {
                return redirect()->route('admin.categorias.index')
                    ->with('error', 'No se pudo eliminar la categoría. Verifica dependencias.');
            }
        }
    }
