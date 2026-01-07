<?php

namespace App\Http\Controllers;

use App\Models\ClassificationRule;
use App\Models\Partner;
use App\Models\Category;
use Illuminate\Http\Request;

class ClassificationRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rules = ClassificationRule::where('company_id', auth()->user()->company_id)
            ->with(['partner', 'suggestedCategory'])
            ->get();
        return view('accounting.rules.index', compact('rules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $partners = Partner::where('company_id', auth()->user()->company_id)->get();
        $categories = Category::where('company_id', auth()->user()->company_id)->get();
        
        return view('accounting.rules.create', compact('partners', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'suggested_category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:500',
        ]);

        $rule = ClassificationRule::create([
            'company_id' => auth()->user()->company_id,
            'partner_id' => $request->partner_id,
            'suggested_category_id' => $request->suggested_category_id,
            'description' => $request->description,
        ]);

        return redirect()->route('accounting.rules.index')->with('success', 'Regla de clasificación creada exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassificationRule $rule)
    {
        // Asegurar que la regla pertenece a la empresa del usuario actual
        if ($rule->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        $partners = Partner::where('company_id', auth()->user()->company_id)->get();
        $categories = Category::where('company_id', auth()->user()->company_id)->get();
        
        return view('accounting.rules.edit', compact('rule', 'partners', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassificationRule $rule)
    {
        // Asegurar que la regla pertenece a la empresa del usuario actual
        if ($rule->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'suggested_category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:500',
        ]);

        $rule->update([
            'partner_id' => $request->partner_id,
            'suggested_category_id' => $request->suggested_category_id,
            'description' => $request->description,
        ]);

        return redirect()->route('accounting.rules.index')->with('success', 'Regla de clasificación actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassificationRule $rule)
    {
        // Asegurar que la regla pertenece a la empresa del usuario actual
        if ($rule->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        $rule->delete();

        return redirect()->route('accounting.rules.index')->with('success', 'Regla de clasificación eliminada exitosamente.');
    }
}