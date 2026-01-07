<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClassificationRuleController;
use App\Http\Controllers\SettingsController;

// Ruta principal
Route::get('/', function () {
    return view('welcome');
});

// Rutas para Socios de Negocio
Route::resource('partners', PartnerController::class)->names([
    'index' => 'partners.index',
    'create' => 'partners.create',
    'store' => 'partners.store',
    'edit' => 'partners.edit',
    'update' => 'partners.update',
    'destroy' => 'partners.destroy'
]);

// Rutas para Ventas
Route::resource('sales', SalesController::class)->names([
    'index' => 'sales.index',
    'create' => 'sales.create',
    'store' => 'sales.store',
    'edit' => 'sales.edit',
    'update' => 'sales.update',
    'destroy' => 'sales.destroy'
]);

// Rutas para Categorías (en el módulo de Contabilidad)
Route::prefix('accounting')->name('accounting.')->group(function () {
    Route::resource('categories', CategoryController::class)->names([
        'index' => 'categories.index',
        'create' => 'categories.create',
        'store' => 'categories.store',
        'edit' => 'categories.edit',
        'update' => 'categories.update',
        'destroy' => 'categories.destroy'
    ]);
    
    // Rutas para Reglas de Clasificación
    Route::resource('rules', ClassificationRuleController::class)->names([
        'index' => 'rules.index',
        'create' => 'rules.create',
        'store' => 'rules.store',
        'edit' => 'rules.edit',
        'update' => 'rules.update',
        'destroy' => 'rules.destroy'
    ]);
});

// Rutas para Configuración
Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('company', [SettingsController::class, 'company'])->name('company');
    Route::put('company', [SettingsController::class, 'updateCompany'])->name('company.update');
});
