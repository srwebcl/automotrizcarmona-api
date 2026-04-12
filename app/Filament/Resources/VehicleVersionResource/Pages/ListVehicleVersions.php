<?php

namespace App\Filament\Resources\VehicleVersionResource\Pages;

use App\Filament\Resources\VehicleVersionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVehicleVersions extends ListRecords
{
    protected static string $resource = VehicleVersionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        $tabs = ['all' => \Filament\Resources\Components\Tab::make('Todas')];

        $brands = \Illuminate\Support\Facades\Cache::remember('brands_for_tabs', 300, fn() => \App\Models\Brand::where('is_active', true)->orderBy('name')->get());

        foreach ($brands as $brand) {
            $tabs[$brand->slug] = \Filament\Resources\Components\Tab::make($brand->name)
                ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->whereHas('vehicleModel', fn (\Illuminate\Database\Eloquent\Builder $q) => $q->where('brand_id', $brand->id)));
        }

        return $tabs;
    }
}
