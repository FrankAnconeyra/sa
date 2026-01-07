@extends('layouts.app')

@section('title', 'Nueva Regla de Clasificación')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Nueva Regla de Clasificación</h1>
                <a href="{{ route('accounting.rules.index') }}" class="btn btn-secondary">Volver</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('accounting.rules.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="partner_id" class="form-label">Cliente (Opcional)</label>
                            <select class="form-select" id="partner_id" name="partner_id">
                                <option value="">Todos los clientes</option>
                                @foreach($partners as $partner)
                                <option value="{{ $partner->id }}">{{ $partner->name }} ({{ $partner->document_type }}: {{ $partner->document_number }})</option>
                                @endforeach
                            </select>
                            <div class="form-text">Dejar vacío para aplicar a todos los clientes</div>
                        </div>

                        <div class="mb-3">
                            <label for="keyword" class="form-label">Palabra Clave</label>
                            <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Ej: 'Luz', 'Agua', 'Internet'">
                            <div class="form-text">Palabra clave que se buscará en el nombre del documento</div>
                        </div>

                        <div class="mb-3">
                            <label for="suggested_category_id" class="form-label">Categoría Sugerida</label>
                            <select class="form-select" id="suggested_category_id" name="suggested_category_id" required>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }} ({{ $category->type }})</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Crear Regla</button>
                        <a href="{{ route('accounting.rules.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection