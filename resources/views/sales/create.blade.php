@extends('layouts.app')

@section('title', 'Nueva Venta')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Nueva Venta</h1>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">Volver</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-4" id="saleTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab">Subir XML</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="manual-tab" data-bs-toggle="tab" data-bs-target="#manual" type="button" role="tab">Ingreso Manual</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="saleTabContent">
                        <!-- Subir XML -->
                        <div class="tab-pane fade show active" id="upload" role="tabpanel">
                            <form action="{{ route('sales.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="operation_type" value="sale">
                                
                                <div class="mb-3">
                                    <label for="xml_file" class="form-label">Archivo XML</label>
                                    <input type="file" class="form-control" id="xml_file" name="xml_file" accept=".xml" required>
                                    <div class="form-text">Sube el archivo XML de la factura electrónica</div>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Procesar XML</button>
                                </div>
                            </form>
                        </div>

                        <!-- Ingreso Manual -->
                        <div class="tab-pane fade" id="manual" role="tabpanel">
                            <form action="{{ route('sales.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="operation_type" value="sale">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="partner_id" class="form-label">Cliente</label>
                                            <select class="form-select" id="partner_id" name="partner_id">
                                                <option value="">Seleccionar cliente</option>
                                                @foreach($partners as $partner)
                                                <option value="{{ $partner->id }}" 
                                                    data-document-number="{{ $partner->document_number }}"
                                                    data-document-type="{{ $partner->document_type }}">
                                                    {{ $partner->name }} ({{ $partner->document_type }}: {{ $partner->document_number }})
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createPartnerModal">
                                                    Nuevo Cliente
                                                </button>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Categoría</label>
                                            <select class="form-select" id="category_id" name="category_id" required>
                                                <option value="">Seleccionar categoría</option>
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="sunat_type_id" class="form-label">Tipo de Documento</label>
                                            <select class="form-select" id="sunat_type_id" name="sunat_type_id" required>
                                                @foreach($documentTypes as $type)
                                                <option value="{{ $type->id }}">{{ $type->description }} ({{ $type->code }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="serie" class="form-label">Serie</label>
                                            <input type="text" class="form-control" id="serie" name="serie" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="numero" class="form-label">Número</label>
                                            <input type="number" class="form-control" id="numero" name="numero" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="issue_date" class="form-label">Fecha de Emisión</label>
                                            <input type="date" class="form-control" id="issue_date" name="issue_date" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="due_date" class="form-label">Fecha de Vencimiento</label>
                                            <input type="date" class="form-control" id="due_date" name="due_date">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="currency" class="form-label">Moneda</label>
                                            <select class="form-select" id="currency" name="currency">
                                                <option value="PEN" selected>Soles (PEN)</option>
                                                <option value="USD">Dólares (USD)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="exchange_rate" class="form-label">Tipo de Cambio</label>
                                            <input type="number" class="form-control" id="exchange_rate" name="exchange_rate" step="0.0001" value="1.0000" min="0">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Estado</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="registrado" selected>Registrado</option>
                                                <option value="anulado">Anulado</option>
                                                <option value="procesando">Procesando</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="subtotal" class="form-label">Subtotal</label>
                                            <input type="number" class="form-control" id="subtotal" name="subtotal" step="0.01" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="igv" class="form-label">IGV</label>
                                            <input type="number" class="form-control" id="igv" name="igv" step="0.01" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="total" class="form-label">Total</label>
                                            <input type="number" class="form-control" id="total" name="total" step="0.01" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notas</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Guardar Venta</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para crear nuevo cliente -->
    <div class="modal fade" id="createPartnerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="partnerForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="document_type" class="form-label">Tipo de Documento</label>
                            <select class="form-select" id="document_type" name="document_type">
                                <option value="RUC">RUC</option>
                                <option value="DNI">DNI</option>
                                <option value="CE">CE</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="document_number" class="form-label">Número de Documento</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="document_number" name="document_number">
                                <button class="btn btn-outline-secondary" type="button" id="consultRucBtn">Consultar SUNAT</button>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre/Razón Social</label>
                            <input type="text" class="form-control" id="name" name="name" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Dirección</label>
                            <textarea class="form-control" id="address" name="address" rows="2" readonly></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                    </div>
                </form>
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
                } else {
                    alert('Documento no encontrado en SUNAT');
                    document.getElementById('name').value = '';
                    document.getElementById('address').value = '';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al consultar el documento');
            });
    });
    
    // Actualizar valores en el formulario principal al seleccionar cliente
    document.getElementById('partner_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            document.getElementById('document_number').value = selectedOption.dataset.documentNumber;
        }
    });
});
</script>
@endsection