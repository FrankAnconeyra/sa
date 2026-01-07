<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Partner;
use App\Models\Category;
use App\Models\SunatDocumentType;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::where('company_id', auth()->user()->company_id)
            ->whereHas('sunatType', function($query) {
                $query->whereIn('code', ['01', '03', '07', '08']); // Facturas, boletas, notas de crédito, notas de débito
            })
            ->with(['partner', 'category', 'sunatType'])
            ->get();
            
        return view('sales.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $partners = Partner::where('company_id', auth()->user()->company_id)->get();
        $categories = Category::where('company_id', auth()->user()->company_id)->get();
        $documentTypes = SunatDocumentType::all(); // Puedes filtrar según sea necesario
        
        return view('sales.create', compact('partners', 'categories', 'documentTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'sunat_type_id' => 'required|exists:sunat_document_types,id',
            'category_id' => 'required|exists:categories,id',
            'serie' => 'required|string|max:20',
            'correlative' => 'required|string|max:20',
            'issue_date' => 'required|date',
            'due_date' => 'nullable|date',
            'total_amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
        ]);

        $document = Document::create([
            'company_id' => auth()->user()->company_id,
            'partner_id' => $request->partner_id,
            'sunat_type_id' => $request->sunat_type_id,
            'category_id' => $request->category_id,
            'serie' => $request->serie,
            'correlative' => $request->correlative,
            'issue_date' => $request->issue_date,
            'due_date' => $request->due_date,
            'total_amount' => $request->total_amount,
            'description' => $request->description,
        ]);

        return redirect()->route('sales.index')->with('success', 'Venta creada exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        // Asegurar que el documento pertenece a la empresa del usuario actual
        if ($document->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        $partners = Partner::where('company_id', auth()->user()->company_id)->get();
        $categories = Category::where('company_id', auth()->user()->company_id)->get();
        $documentTypes = SunatDocumentType::all();
        
        return view('sales.edit', compact('document', 'partners', 'categories', 'documentTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        // Asegurar que el documento pertenece a la empresa del usuario actual
        if ($document->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'sunat_type_id' => 'required|exists:sunat_document_types,id',
            'category_id' => 'required|exists:categories,id',
            'serie' => 'required|string|max:20',
            'correlative' => 'required|string|max:20',
            'issue_date' => 'required|date',
            'due_date' => 'nullable|date',
            'total_amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
        ]);

        $document->update([
            'partner_id' => $request->partner_id,
            'sunat_type_id' => $request->sunat_type_id,
            'category_id' => $request->category_id,
            'serie' => $request->serie,
            'correlative' => $request->correlative,
            'issue_date' => $request->issue_date,
            'due_date' => $request->due_date,
            'total_amount' => $request->total_amount,
            'description' => $request->description,
        ]);

        return redirect()->route('sales.index')->with('success', 'Venta actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        // Asegurar que el documento pertenece a la empresa del usuario actual
        if ($document->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        $document->delete();

        return redirect()->route('sales.index')->with('success', 'Venta eliminada exitosamente.');
    }
}