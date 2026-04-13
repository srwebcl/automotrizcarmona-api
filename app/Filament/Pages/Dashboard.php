<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected function getHeaderActions(): array
    {
        return [
            Action::make('createBrand')
                ->label('Crear Marca Livianos')
                ->icon('heroicon-o-tag')
                ->color('info')
                ->url(fn (): string => \App\Filament\Resources\BrandResource::getUrl('create')),
                
            Action::make('createTruckBrand')
                ->label('Crear Marca Camiones')
                ->icon('heroicon-o-tag')
                ->color('info')
                ->url(fn (): string => \App\Filament\Resources\TruckBrandResource::getUrl('create')),
                
            Action::make('createVehicle')
                ->label('Nuevo Modelo Livianos')
                ->icon('heroicon-o-truck')
                ->color('success')
                ->url(fn (): string => \App\Filament\Resources\VehicleModelResource::getUrl('create')),
                
            Action::make('createTruck')
                ->label('Nuevo Modelo Camiones')
                ->icon('heroicon-o-truck')
                ->color('success')
                ->url(fn (): string => \App\Filament\Resources\TruckResource::getUrl('create')),
                
            Action::make('updatePrices')
                ->label('Actualizar Precios')
                ->icon('heroicon-o-currency-dollar')
                ->color('warning')
                ->url(fn (): string => \App\Filament\Resources\VehicleVersionResource::getUrl('index')),
                
            Action::make('createBanner')
                ->label('Añadir un Banner')
                ->icon('heroicon-o-presentation-chart-bar')
                ->color('danger')
                ->url(fn (): string => \App\Filament\Resources\BannerResource::getUrl('create')),
        ];
    }
}
