@extends('layouts.app')

@section('title', 'Editar Venta')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Editar Venta</h1>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">Volver</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('sales.update', $document->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="partner_id" class="form-label">Cliente</label>
                                    <select class="form-select" id="partner_id" name="partner_id">
                                        <option value="">Seleccionar cliente</option>
                                        @foreach($partners as $partner)
                                        <option value="{{ $partner->id }}" 
                                            {{ $document->partner_id == $partner->id ? 'selected' : '' }}
                                            data-document-number="{{ $partner->document_number }}"
                                            data-document-type="{{ $partner->document_type }}">
                                            {{ $partner->name }} ({{ $partner->document_type }}: {{ $partner->document_number }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Categoría</label>
                                    <select class="form-select" id="category_id" name="category_id">
                                        <option value="">Seleccionar categoría</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $document->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="sunat_type_id" class="form-label">Tipo de Documento</label>
                                    <select class="form-select" id="sunat_type_id" name="sunat_type_id" required>
                                        @foreach($documentTypes as $type)
                                        <option value="{{ $type->id }}" {{ $document->sunat_type_id == $type->id ? 'selected' : '' }}>
                                            {{ $type->description }} ({{ $type->code }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="serie" class="form-label">Serie</label>
                                    <input type="text" class="form-control" id="serie" name="serie" value="{{ old('serie', $document->serie) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="numero" class="form-label">Número</label>
                                    <input type="number" class="form-control" id="numero" name="numero" value="{{ old('numero', $document->numero) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="issue_date" class="form-label">Fecha de Emisión</label>
                                    <input type="date" class="form-control" id="issue_date" name="issue_date" value="{{ old('issue_date', $document->issue_date->format('Y-m-d')) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="due_date" class="form-label">Fecha de Vencimiento</label>
                                    <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date', $document->due_date ? $document->due_date->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="currency" class="form-label">Moneda</label>
                                    <select class="form-select" id="currency" name="currency">
                                        <option value="PEN" {{ $document->currency == 'PEN' ? 'selected' : '' }}>Soles (PEN)</option>
                                        <option value="USD" {{ $document->currency == 'USD' ? 'selected' : '' }}>Dólares (USD)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="exchange_rate" class="form-label">Tipo de Cambio</label>
                                    <input type="number" class="form-control" id="exchange_rate" name="exchange_rate" step="0.0001" value="{{ old('exchange_rate', $document->exchange_rate) }}" min="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Estado</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="registrado" {{ $document->status == 'registrado' ? 'selected' : '' }}>Registrado</option>
                                        <option value="anulado" {{ $document->status == 'anulado' ? 'selected' : '' }}>Anulado</option>
                                        <option value="procesando" {{ $document->status == 'procesando' ? 'selected' : '' }}>Procesando</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="subtotal" class="form-label">Subtotal</label>
                                    <input type="number" class="form-control" id="subtotal" name="subtotal" step="0.01" value="{{ old('subtotal', $document->subtotal) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="igv" class="form-label">IGV</label>
                                    <input type="number" class="form-control" id="igv" name="igv" step="0.01" value="{{ old('igv', $document->igv) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="total" class="form-label">Total</label>
                                    <input type="number" class="form-control" id="total" name="total" step="0.01" value="{{ old('total', $document->total) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notas</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $document->notes) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Actualizar Venta</button>
                        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection