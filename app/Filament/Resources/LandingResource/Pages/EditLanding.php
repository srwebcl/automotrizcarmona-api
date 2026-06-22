<?php

namespace App\Filament\Resources\LandingResource\Pages;

use App\Filament\Resources\LandingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLanding extends EditRecord
{
    protected static string $resource = LandingResource::class;

    public function getBreadcrumbs(): array
    {
        $slug = $this->record->slug;
        if ($slug === 'electromovilidad') {
            return [
                \App\Filament\Resources\EcoModelResource::getUrl() => 'Electromovilidad',
                '#' => 'Personalizar',
            ];
        }
        if ($slug === 'liquidacion') {
            return [
                \App\Filament\Resources\PromotionUnitResource::getUrl() => 'Liquidación',
                '#' => 'Personalizar',
            ];
        }

        return parent::getBreadcrumbs();
    }

    protected function getHeaderActions(): array
    {
        $slug = $this->record->slug;
        $backUrl = $slug === 'electromovilidad' 
            ? \App\Filament\Resources\EcoModelResource::getUrl() 
            : ($slug === 'liquidacion' ? \App\Filament\Resources\PromotionUnitResource::getUrl() : LandingResource::getUrl('index'));

        return [
            Actions\Action::make('volver')
                ->label('Volver al Listado')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url($backUrl),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        $slug = $this->record->slug;
        return $slug === 'electromovilidad' 
            ? \App\Filament\Resources\EcoModelResource::getUrl() 
            : ($slug === 'liquidacion' ? \App\Filament\Resources\PromotionUnitResource::getUrl() : LandingResource::getUrl('index'));
    }
}
