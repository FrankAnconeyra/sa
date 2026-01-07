@extends('layouts.app')

@section('title', 'Reglas de Clasificación')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Reglas de Clasificación Automática</h1>
                <a href="{{ route('accounting.rules.create') }}" class="btn btn-primary">Nueva Regla</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Palabra Clave</th>
                                    <th>Categoría Sugerida</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rules as $rule)
                                <tr>
                                    <td>{{ $rule->id }}</td>
                                    <td>{{ $rule->partner ? $rule->partner->name : 'Todos los clientes' }}</td>
                                    <td>{{ $rule->keyword ? $rule->keyword : 'N/A' }}</td>
                                    <td>{{ $rule->suggestedCategory->name }}</td>
                                    <td>
                                        <a href="{{ route('accounting.rules.edit', $rule->id) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                        <form action="{{ route('accounting.rules.destroy', $rule->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Está seguro de eliminar esta regla?')">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No hay reglas de clasificación registradas</td>
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