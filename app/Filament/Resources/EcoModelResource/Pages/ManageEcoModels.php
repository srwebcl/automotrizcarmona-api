<?php

namespace App\Filament\Resources\EcoModelResource\Pages;

use App\Filament\Resources\EcoModelResource;
use Filament\Resources\Pages\ManageRecords;

class ManageEcoModels extends ManageRecords
{
    protected static string $resource = EcoModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('personalizar_lp')
                ->label('Personalizar LP')
                ->icon('heroicon-o-pencil-square')
                ->color('success')
                ->url(fn () => \App\Filament\Resources\LandingResource::getUrl('edit', ['record' => \App\Models\Landing::where('slug', 'electromovilidad')->first()?->id ?? 0])),
        ];
    }
}
