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
use App\Models\MarketingScript;
use App\Models\News;
use App\Models\VehicleModel;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

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
            ->with(['vehicleVersions', 'promotionUnits'])
            ->orderBy('order')
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
            ->with(['brand', 'vehicleVersions', 'features', 'promotionUnits'])
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
            ->with(['brand', 'promotionUnits' => function ($query) {
                $query->where('is_active', true)->orderBy('order', 'asc');
            }])
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
            ->orderBy('eco_order', 'asc')
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
        $docs = \App\Models\LegalDocument::with(['legalable'])
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($doc) {
                $plainText = strip_tags($doc->content);
                $excerpt = strlen($plainText) > 300 ? substr($plainText, 0, 300) . '...' : ($plainText ?: 'Ver condiciones y términos legales aplicables.');
                
                $brand = $doc->legalable instanceof \App\Models\Brand ? $doc->legalable : null;
                $landing = $doc->legalable instanceof \App\Models\Landing ? $doc->legalable : null;
                
                return [
                    'id' => $doc->id,
                    'title' => $doc->title,
                    'excerpt' => $excerpt,
                    'content' => $doc->content,
                    'brand_name' => $brand ? $brand->name : ($landing ? $landing->title : 'Carmona Auto'),
                    'brand_slug' => $brand ? $brand->slug : ($landing ? $landing->slug : 'carmona'),
                    'logo_url' => $brand ? $brand->logo_url : null,
                ];
            });

        return response()->json($docs);
    }

    /**
     * Get discover items for the 'Más sobre Carmona y Cia' home section.
     */
    public function discoverItems(): \Illuminate\Http\JsonResponse
    {
        $items = Banner::where('active', true)
            ->where('location', 'home_discover')
            ->orderBy('order')
            ->get()
            ->map(function ($banner) {
                // Resolve link: prefer external_link from custom_data, then internal_link, then link column
                $customData = $banner->custom_data ?? [];
                $link = $banner->link;
                $isExternal = false;

                if (!empty($customData['external_link'])) {
                    $link = $customData['external_link'];
                    $isExternal = true;
                } elseif (!empty($customData['internal_link'])) {
                    $link = $customData['internal_link'];
                } elseif (!empty($banner->link)) {
                    // Determine if it's external by checking if it starts with http
                    $isExternal = str_starts_with($banner->link, 'http');
                }

                return [
                    'id' => $banner->id,
                    'title' => $banner->title,
                    'subtitle' => $banner->subtitle,
                    'image' => $banner->image_desktop,
                    'link' => $link ?? '/',
                    'external' => $isExternal,
                    'order' => $banner->order,
                ];
            });

        return response()->json($items);
    }

    /**
     * Get active marketing scripts (GTM, GA4, Hotjar, etc.) for frontend injection.
     * Cached for 1 hour — use /refresh to clear cache immediately.
     */
    public function marketingScripts(): \Illuminate\Http\JsonResponse
    {
        $scripts = Cache::remember('marketing_scripts', 3600, function () {
            return MarketingScript::where('is_active', true)
                ->orderBy('order')
                ->get(['type', 'value', 'placement'])
                ->toArray();
        });

        return response()->json($scripts);
    }

    /**
     * Force-refresh the marketing scripts cache.
     * Call this after making changes in the admin panel for immediate propagation.
     */
    public function refreshMarketingScripts(): \Illuminate\Http\JsonResponse
    {
        Cache::forget('marketing_scripts');

        $scripts = MarketingScript::where('is_active', true)
            ->orderBy('order')
            ->get(['type', 'value', 'placement'])
            ->toArray();

        Cache::put('marketing_scripts', $scripts, 3600);

        return response()->json([
            'message' => 'Caché de scripts de marketing actualizado.',
            'count'   => count($scripts),
        ]);
    }
}
