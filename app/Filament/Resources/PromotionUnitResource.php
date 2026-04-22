<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromotionUnitResource\Pages;
use App\Filament\Resources\PromotionUnitResource\RelationManagers;
use App\Models\PromotionUnit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PromotionUnitResource extends Resource
{
    protected static ?string $model = PromotionUnit::class;

    protected static ?string $navigationIcon = 'heroicon-o-fire';
    
    protected static ?string $navigationLabel = 'Unidades en Liquidación';
    
    protected static ?string $pluralLabel = 'Unidades en Liquidación';
    
    protected static ?string $navigationGroup = 'Marketing';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('vehicle_model_id')
                    ->relationship('vehicleModel', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Modelo de Vehículo'),
                Forms\Components\TextInput::make('vin')
                    ->required()
                    ->maxLength(255)
                    ->label('VIN / Chasis'),
                Forms\Components\TextInput::make('version_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nombre de Versión'),
                Forms\Components\TextInput::make('list_price')
                    ->numeric()
                    ->required()
                    ->prefix('$')
                    ->label('Precio de Lista'),
                Forms\Components\TextInput::make('promo_price')
                    ->numeric()
                    ->required()
                    ->prefix('$')
                    ->label('Precio Liquidación'),
                Forms\Components\TextInput::make('promo_bonus')
                    ->numeric()
                    ->required()
                    ->prefix('$')
                    ->label('Bono de Descuento'),
                Forms\Components\Select::make('status')
                    ->options([
                        'disponible' => 'Disponible',
                        'reservado' => 'Reservado',
                        'vendido' => 'Vendido',
                    ])
                    ->default('disponible')
                    ->required()
                    ->label('Estado'),
                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->label('Activo')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vehicleModel.name')
                    ->searchable()
                    ->sortable()
                    ->label('Modelo'),
                Tables\Columns\TextColumn::make('vin')
                    ->searchable()
                    ->label('VIN'),
                Tables\Columns\TextColumn::make('version_name')
                    ->searchable()
                    ->label('Versión'),
                Tables\Columns\TextColumn::make('promo_price')
                    ->money('clp')
                    ->sortable()
                    ->label('Precio Liq.'),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'disponible' => 'Disponible',
                        'reservado' => 'Reservado',
                        'vendido' => 'Vendido',
                    ])
                    ->sortable()
                    ->label('Estado'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Activo'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'disponible' => 'Disponible',
                        'reservado' => 'Reservado',
                        'vendido' => 'Vendido',
                    ])
                    ->label('Estado'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePromotionUnits::route('/'),
        ];
    }
}
