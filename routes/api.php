<?php

use App\Http\Controllers\Api\V1\CatalogController;
use App\Http\Controllers\Api\V1\LeadController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    
    // Catálogo Público
    Route::get('/layout/brands', [CatalogController::class, 'layoutBrands']);
    Route::get('/brands', [CatalogController::class, 'brands']);
    Route::get('/models/{brand_slug}', [CatalogController::class, 'modelsByBrand']);
    Route::get('/models/{brand_slug}/{model_slug}', [CatalogController::class, 'modelDetails']);
    Route::get('/featured', [CatalogController::class, 'featured']);
    Route::get('/brands/{slug}', [CatalogController::class, 'brandBySlug']);
    
    // Marketing & Información Extra
    Route::get('/banners', [CatalogController::class, 'banners']);
    Route::get('/branches', [CatalogController::class, 'branches']);
    Route::get('/news', [CatalogController::class, 'news']);
    Route::get('/news/{slug}', [CatalogController::class, 'newsBySlug']);

    // Landings & Especiales
    Route::get('/landings/{slug}', [CatalogController::class, 'landingInfo']);
    Route::get('/promotions', [CatalogController::class, 'promotions']);
    Route::get('/electromovilidad', [CatalogController::class, 'electromovilidad']);
    Route::get('/legal-documents', [CatalogController::class, 'legalDocuments']);

    // Captura de Leads (Marketing & Ventas)
    Route::post('/leads', [LeadController::class, 'store']);

    // Camiones
    Route::get('/truck-brands', [App\Http\Controllers\Api\TruckController::class, 'getBrands']);
    Route::get('/truck-brands/{slug}/trucks', [App\Http\Controllers\Api\TruckController::class, 'getTrucksByBrand']);
    
    // Temporal DB Fix
    Route::get('/fix-db', function () {
        if (!\Illuminate\Support\Facades\Schema::hasColumn('vehicle_models', 'includes_iva')) {
            \Illuminate\Support\Facades\Schema::table('vehicle_models', function ($table) {
                $table->boolean('includes_iva')->default(true);
            });
            return response()->json(['message' => 'Columna includes_iva agregada exitosamente a la base de datos web.']);
        }
        return response()->json(['message' => 'La columna ya existe en esta base de datos. Ninguna accion tomada.']);
    });
});
