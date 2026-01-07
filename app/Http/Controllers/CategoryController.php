<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('company_id', auth()->user()->company_id)->get();
        return view('accounting.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('accounting.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:7', // Para códigos de color hexadecimales
        ]);

        $category = Category::create([
            'company_id' => auth()->user()->company_id,
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
        ]);

        return redirect()->route('accounting.categories.index')->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // Asegurar que la categoría pertenece a la empresa del usuario actual
        if ($category->company_id !== auth()->user()->company_id) {
            abort(403);
        }
        
        return view('accounting.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // Asegurar que la categoría pertenece a la empresa del usuario actual
        if ($category->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:7',
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
        ]);

        return redirect()->route('accounting.categories.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Asegurar que la categoría pertenece a la empresa del usuario actual
        if ($category->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        // Verificar que no tenga documentos asociados antes de eliminar
        if ($category->documents()->count() > 0) {
            return redirect()->route('accounting.categories.index')
                ->with('error', 'No se puede eliminar la categoría porque tiene documentos asociados.');
        }

        $category->delete();

        return redirect()->route('accounting.categories.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}