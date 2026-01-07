@extends('layouts.app')

@section('title', 'Editar Categoría')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Editar Categoría</h1>
                <a href="{{ route('accounting.categories.index') }}" class="btn btn-secondary">Volver</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('accounting.categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Tipo</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="income" {{ $category->type === 'income' ? 'selected' : '' }}>Ingreso</option>
                                <option value="expense" {{ $category->type === 'expense' ? 'selected' : '' }}>Gasto</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="accounting_code" class="form-label">Código Contable</label>
                            <input type="text" class="form-control" id="accounting_code" name="accounting_code" value="{{ old('accounting_code', $category->accounting_code) }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Actualizar Categoría</button>
                        <a href="{{ route('accounting.categories.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection