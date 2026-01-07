@extends('layouts.app')

@section('title', 'Nuevo Socio de Negocio')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Nuevo Socio de Negocio</h1>
                <a href="{{ route('partners.index') }}" class="btn btn-secondary">Volver</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('partners.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="document_type" class="form-label">Tipo de Documento</label>
                                    <select class="form-select" id="document_type" name="document_type" required>
                                        <option value="RUC">RUC</option>
                                        <option value="DNI">DNI</option>
                                        <option value="CE">CE</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="document_number" class="form-label">Número de Documento</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="document_number" name="document_number" required>
                                        <button class="btn btn-outline-secondary" type="button" id="consultRucBtn">Consultar SUNAT</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre/Razón Social</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Dirección</label>
                            <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tipo de Socio</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="is_customer" name="is_customer" value="1">
                                            <label class="form-check-label" for="is_customer">Cliente</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="is_supplier" name="is_supplier" value="1">
                                            <label class="form-check-label" for="is_supplier">Proveedor</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status_sunat" class="form-label">Estado SUNAT</label>
                            <input type="text" class="form-control" id="status_sunat" name="status_sunat">
                        </div>

                        <div class="mb-3">
                            <label for="condition_sunat" class="form-label">Condición SUNAT</label>
                            <input type="text" class="form-control" id="condition_sunat" name="condition_sunat">
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar Socio</button>
                        <a href="{{ route('partners.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Consulta de RUC/DNI a la API
    document.getElementById('consultRucBtn').addEventListener('click', function() {
        const documentNumber = document.getElementById('document_number').value;
        const documentType = document.getElementById('document_type').value;
        
        if (!documentNumber) {
            alert('Ingrese un número de documento');
            return;
        }
        
        // Determinar si es RUC o DNI/CE para la API
        const endpoint = documentType === 'RUC' ? 
            `https://dniruc.apisperu.com/api/v1/ruc/${documentNumber}?token=YOUR_API_TOKEN_HERE` :
            `https://dniruc.apisperu.com/api/v1/dni/${documentNumber}?token=YOUR_API_TOKEN_HERE`;
        
        fetch(endpoint)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('name').value = data.nombre || data.razonSocial || '';
                    document.getElementById('address').value = data.direccion || data.address || '';
                    document.getElementById('status_sunat').value = data.estado || '';
                    document.getElementById('condition_sunat').value = data.condicion || '';
                } else {
                    alert('Documento no encontrado en SUNAT');
                    document.getElementById('name').value = '';
                    document.getElementById('address').value = '';
                    document.getElementById('status_sunat').value = '';
                    document.getElementById('condition_sunat').value = '';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al consultar el documento');
            });
    });
});
</script>
@endsection