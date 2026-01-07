@extends('layouts.app')

@section('title', 'Socios de Negocio')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Directorio de Socios de Negocio</h1>
                <a href="{{ route('partners.create') }}" class="btn btn-primary">Nuevo Socio</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="partners-table">
                            <thead>
                                <tr>
                                    <th>Tipo Doc.</th>
                                    <th>Número Doc.</th>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                    <th>Tipo</th>
                                    <th>Estado SUNAT</th>
                                    <th>Condición SUNAT</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($partners as $partner)
                                <tr>
                                    <td>{{ $partner->document_type }}</td>
                                    <td>{{ $partner->document_number }}</td>
                                    <td>{{ $partner->name }}</td>
                                    <td>{{ $partner->address ?? 'N/A' }}</td>
                                    <td>
                                        @if($partner->is_supplier && $partner->is_customer)
                                            <span class="badge bg-secondary">Cliente/Proveedor</span>
                                        @elseif($partner->is_supplier)
                                            <span class="badge bg-warning">Proveedor</span>
                                        @elseif($partner->is_customer)
                                            <span class="badge bg-info">Cliente</span>
                                        @else
                                            <span class="badge bg-light">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $partner->status_sunat ?? 'N/A' }}</td>
                                    <td>{{ $partner->condition_sunat ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('partners.edit', $partner->id) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                        <a href="#" class="btn btn-sm btn-outline-secondary">Ver</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No hay socios registrados</td>
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