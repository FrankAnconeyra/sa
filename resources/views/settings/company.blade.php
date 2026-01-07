@extends('layouts.app')

@section('title', 'Configuración de Empresa')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Configuración de Empresa</h1>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('settings.company.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="ruc" class="form-label">RUC</label>
                            <input type="text" class="form-control" id="ruc" name="ruc" value="{{ old('ruc', $company->ruc) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="razon_social" class="form-label">Razón Social</label>
                            <input type="text" class="form-control" id="razon_social" name="razon_social" value="{{ old('razon_social', $company->razon_social) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <textarea class="form-control" id="direccion" name="direccion" rows="3">{{ old('direccion', $company->direccion) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo</label>
                            <input type="file" class="form-control" id="logo" name="logo">
                            @if($company->logo_path)
                                <div class="mt-2">
                                    <img src="{{ asset($company->logo_path) }}" alt="Logo actual" class="img-thumbnail" style="max-height: 100px;">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="sol_user" class="form-label">Usuario SOL</label>
                            <input type="text" class="form-control" id="sol_user" name="sol_user" value="{{ old('sol_user', $company->sol_user) }}">
                        </div>

                        <div class="mb-3">
                            <label for="sol_password" class="form-label">Contraseña SOL</label>
                            <input type="password" class="form-control" id="sol_password" name="sol_password" placeholder="Dejar vacío para mantener la actual">
                        </div>

                        <button type="submit" class="btn btn-primary">Actualizar Configuración</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection