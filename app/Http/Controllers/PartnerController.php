<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Company;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partners = Partner::where('company_id', auth()->user()->company_id)->get();
        return view('partners.index', compact('partners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('partners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string|max:10',
            'document_number' => 'required|string|unique:partners,document_number',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'is_customer' => 'boolean',
            'is_supplier' => 'boolean',
        ]);

        $partner = Partner::create([
            'company_id' => auth()->user()->company_id,
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_customer' => $request->is_customer ?? false,
            'is_supplier' => $request->is_supplier ?? false,
        ]);

        return redirect()->route('partners.index')->with('success', 'Socio creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partner $partner)
    {
        // Asegurar que el socio pertenece a la empresa del usuario actual
        if ($partner->company_id !== auth()->user()->company_id) {
            abort(403);
        }
        
        return view('partners.edit', compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        // Asegurar que el socio pertenece a la empresa del usuario actual
        if ($partner->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        $request->validate([
            'document_type' => 'required|string|max:10',
            'document_number' => 'required|string|unique:partners,document_number,' . $partner->id,
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'is_customer' => 'boolean',
            'is_supplier' => 'boolean',
        ]);

        $partner->update([
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_customer' => $request->is_customer ?? false,
            'is_supplier' => $request->is_supplier ?? false,
        ]);

        return redirect()->route('partners.index')->with('success', 'Socio actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        // Asegurar que el socio pertenece a la empresa del usuario actual
        if ($partner->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        $partner->delete();

        return redirect()->route('partners.index')->with('success', 'Socio eliminado exitosamente.');
    }
}