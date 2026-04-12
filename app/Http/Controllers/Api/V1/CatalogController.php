<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\BannerResource;
use App\Http\Resources\V1\BranchResource;
use App\Http\Resources\V1\BrandResource;
use App\Http\Resources\V1\LandingResource;
use App\Http\Resources\V1\NewsResource;
use App\Http\Resources\V1\VehicleModelResource;
use App\Models\Banner;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Landing;
use App\Models\News;
use App\Models\VehicleModel;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CatalogController extends Controller
{
    /**
     * Get all active banners for Marketing.
     */
    public function banners(): AnonymousResourceCollection
    {
        return BannerResource::collection(Banner::where('active', true)->orderBy('order')->get());
    }

    /**
     * Get all branches.
     */
    public function branches(): AnonymousResourceCollection
    {
        return BranchResource::collection(Branch::all());
    }

    /**
     * Get all news.
     */
    public function news(): AnonymousResourceCollection
    {
        return NewsResource::collection(News::orderByDesc('published_at')->get());
    }

    /**
     * Get single news item by slug.
     */
    public function newsBySlug(string $slug): NewsResource
    {
        return new NewsResource(News::where('slug', $slug)->firstOrFail());
    }

    /**
     * Get all brands.
     */
    public function brands(): AnonymousResourceCollection
    {
        return BrandResource::collection(Brand::where('is_active', true)->orderBy('name')->get());
    }

    /**
     * Get minimal layout brands (Autos & Camiones) with visibility flags for Menu & Services.
     */
    public function layoutBrands(): \Illuminate\Http\JsonResponse
    {
        $cars = Brand::where('is_active', true)
            ->orderBy('name')
            ->get(['name', 'slug', 'logo_url', 'show_in_services', 'show_in_parts', 'show_in_dyp']);
            
        $trucks = \App\Models\TruckBrand::where('is_active', true)
            ->orderBy('name')
            ->get(['name', 'slug', 'logo_url', 'show_in_services', 'show_in_parts', 'show_in_dyp']);

        return response()->json([
            'cars' => $cars,
            'trucks' => $trucks
        ]);
    }

    /**
     * Get models for a specific brand (List view).
     */
    public function modelsByBrand(string $brand_slug): AnonymousResourceCollection
    {
        $brand = Brand::where('slug', $brand_slug)->firstOrFail();
        
        $models = VehicleModel::where('brand_id', $brand->id)
            ->where('is_active', true)
            ->with('vehicleVersions')
            ->orderBy('name')
            ->get();

        return VehicleModelResource::collection($models);
    }

    /**
     * Get detailed brand information.
     */
    public function brandBySlug(string $slug): BrandResource
    {
        $brand = Brand::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
            
        return new BrandResource($brand);
    }

    /**
     * Get detailed model information.
     */
    public function modelDetails(string $brand_slug, string $model_slug): VehicleModelResource
    {
        $brand = Brand::where('slug', $brand_slug)->firstOrFail();

        $model = VehicleModel::where('brand_id', $brand->id)
            ->where('slug', $model_slug)
            ->with(['brand', 'vehicleVersions', 'features'])
            ->firstOrFail();

        return new VehicleModelResource($model);
    }

    /**
     * Get featured models for Home.
     */
    public function featured(): AnonymousResourceCollection
    {
        $models = VehicleModel::where('is_active', true)
            ->where('is_featured', true)
            ->with(['brand', 'vehicleVersions'])
            ->limit(10)
            ->get();

        return VehicleModelResource::collection($models);
    }

    /**
     * Get models for the "Promociones" landing (Models marked with is_promotion).
     */
    public function promotions(): AnonymousResourceCollection
    {
        $models = VehicleModel::where('is_active', true)
            ->where('is_promotion', true)
            ->with(['brand', 'promotionUnits'])
            ->orderBy('name')
            ->get();

        return VehicleModelResource::collection($models);
    }

    /**
     * Get models for "Electromovilidad" landing (Hybrid or Electric).
     */
    public function electromovilidad(): AnonymousResourceCollection
    {
        $models = VehicleModel::where('is_active', true)
            ->where(function($query) {
                $query->where('is_hybrid', true)
                      ->orWhere('is_electric', true);
            })
            ->with(['brand', 'vehicleVersions'])
            ->orderBy('name')
            ->get();

        return VehicleModelResource::collection($models);
    }

    /**
     * Get landing hero configuration by slug.
     */
    public function landingInfo(string $slug): LandingResource
    {
        $landing = Landing::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return new LandingResource($landing);
    }

    /**
     * Get all legal documents.
     */
    public function legalDocuments(): \Illuminate\Http\JsonResponse
    {
        $docs = \App\Models\LegalDocument::with(['brand:id,name,slug,logo_url'])
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($doc) {
                $plainText = strip_tags($doc->content);
                $excerpt = strlen($plainText) > 300 ? substr($plainText, 0, 300) . '...' : ($plainText ?: 'Ver condiciones y términos legales aplicables.');
                return [
                    'id' => $doc->id,
                    'title' => $doc->title,
                    'excerpt' => $excerpt,
                    'content' => $doc->content,
                    'brand_name' => $doc->brand ? $doc->brand->name : 'Carmona Auto',
                    'brand_slug' => $doc->brand ? $doc->brand->slug : 'carmona',
                    'logo_url' => $doc->brand ? $doc->brand->logo_url : null,
                ];
            });

        return response()->json($docs);
    }
}
