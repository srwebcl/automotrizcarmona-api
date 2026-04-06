<?php

use App\Http\Controllers\Api\V1\CatalogController;
use App\Http\Controllers\Api\V1\LeadController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    
    // Catálogo Público
    Route::get('/brands', [CatalogController::class, 'brands']);
    Route::get('/models/{brand_slug}', [CatalogController::class, 'modelsByBrand']);
    Route::get('/models/{brand_slug}/{model_slug}', [CatalogController::class, 'modelDetails']);
    Route::get('/featured', [CatalogController::class, 'featured']);
    Route::get('/brands/{slug}', [CatalogController::class, 'brandBySlug']);
    
    // Marketing & Información Extra
    Route::get('/banners', [CatalogController::class, 'banners']);
    Route::get('/branches', [CatalogController::class, 'branches']);
    Route::get('/news', [CatalogController::class, 'news']);

    // Captura de Leads (Marketing & Ventas)
    Route::post('/leads', [LeadController::class, 'store']);
});
