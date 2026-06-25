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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Landing Pages';
    protected static ?string $navigationLabel = 'Liquidación';
    protected static ?string $pluralLabel = 'Liquidación';
    
    public static function getModelLabel(): string
    {
        return 'Unidad en Liquidación';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Unidades en Liquidación';
    }
    protected static bool $shouldRegisterNavigation = true;

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
                    ->label('N° VIN / Chasis'),
                Forms\Components\TextInput::make('version_name')
                    ->maxLength(255)
                    ->label('Nombre de Versión'),
                Forms\Components\TextInput::make('list_price')
                    ->numeric()
                    ->default(0)
                    ->prefix('$')
                    ->label('Precio Lista ($)'),
                Forms\Components\TextInput::make('promo_price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$')
                    ->label('Precio Liquidación ($)'),
                Forms\Components\TextInput::make('promo_bonus')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$')
                    ->label('Bono Liquidación ($)'),
                Forms\Components\Select::make('status')
                    ->options([
                        'disponible' => 'Disponible',
                        'reservado' => 'Reservado',
                        'vendido' => 'Vendido',
                    ])
                    ->required()
                    ->default('disponible')
                    ->label('Estado'),
                Forms\Components\TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->label('Orden de Visualización'),
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->label('Activo / Disponible'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('order')
            ->defaultSort('order', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('vehicleModel.name')
                    ->numeric()
                    ->sortable()
                    ->label('Modelo'),
                Tables\Columns\TextColumn::make('vin')
                    ->searchable()
                    ->label('VIN'),
                Tables\Columns\TextColumn::make('version_name')
                    ->searchable()
                    ->label('Versión'),
                Tables\Columns\TextColumn::make('list_price')
                    ->numeric()
                    ->money('clp')
                    ->sortable()
                    ->label('Precio Lista'),
                Tables\Columns\TextColumn::make('promo_bonus')
                    ->numeric()
                    ->money('clp')
                    ->sortable()
                    ->label('Bono Liq.'),
                Tables\Columns\TextColumn::make('promo_price')
                    ->numeric()
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
                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable()
                    ->label('Orden'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Activo'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Creado'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Actualizado'),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['vehicleModel']);
    }
}
