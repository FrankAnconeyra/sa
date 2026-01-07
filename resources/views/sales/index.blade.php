@extends('layouts.app')

@section('title', 'Ventas - Listado de Facturas')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Ventas - Facturas Emitidas</h1>
                <a href="{{ route('sales.create') }}" class="btn btn-primary">Nueva Venta</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="sales-table">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Cliente</th>
                                    <th>Tipo Doc.</th>
                                    <th>Serie - Número</th>
                                    <th>Fecha Emisión</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents as $document)
                                <tr>
                                    <td>{{ $document->id }}</td>
                                    <td>{{ $document->partner ? $document->partner->name : 'N/A' }}</td>
                                    <td>{{ $document->sunatDocumentType->description }}</td>
                                    <td>{{ $document->serie }} - {{ $document->numero }}</td>
                                    <td>{{ $document->issue_date->format('d/m/Y') }}</td>
                                    <td>{{ $document->currency }} {{ number_format($document->total, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $document->status === 'registrado' ? 'success' : ($document->status === 'anulado' ? 'danger' : 'warning') }}">
                                            {{ $document->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('sales.edit', $document->id) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                        <a href="#" class="btn btn-sm btn-outline-secondary">Ver</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No hay facturas registradas</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection