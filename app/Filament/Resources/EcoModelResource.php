<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EcoModelResource\Pages;
use App\Models\VehicleModel;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EcoModelResource extends Resource
{
    protected static ?string $model = VehicleModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';
    protected static ?string $navigationLabel = 'Orden Electromovilidad';
    protected static ?string $pluralLabel = 'Electromovilidad';
    protected static ?string $navigationGroup = 'Landing Pages';
    
    // Lo ocultamos del menú principal para acceder desde Landings
    protected static bool $shouldRegisterNavigation = false;

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('eco_order')
            ->defaultSort('eco_order', 'asc')
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail_url')->label('Img')->disk('r2')->square(),
                Tables\Columns\TextColumn::make('brand.name')->label('Marca'),
                Tables\Columns\TextColumn::make('name')->label('Modelo')->searchable(),
                Tables\Columns\ToggleColumn::make('is_electric')->label('Eléctrico'),
                Tables\Columns\ToggleColumn::make('is_hybrid')->label('Híbrido'),
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where(function($q) {
                $q->where('is_electric', true)
                  ->orWhere('is_hybrid', true);
            });
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEcoModels::route('/'),
        ];
    }
}
