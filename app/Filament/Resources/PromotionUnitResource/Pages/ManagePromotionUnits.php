<?php

namespace App\Filament\Resources\PromotionUnitResource\Pages;

use App\Filament\Resources\PromotionUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePromotionUnits extends ManageRecords
{
    protected static string $resource = PromotionUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('personalizar_lp')
                ->label('Personalizar LP')
                ->icon('heroicon-o-pencil-square')
                ->color('success')
                ->url(fn () => \App\Filament\Resources\LandingResource::getUrl('edit', ['record' => \App\Models\Landing::where('slug', 'liquidacion')->first()?->id ?? 0])),
            Actions\CreateAction::make(),
        ];
    }
}
