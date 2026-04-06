<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleVersionResource\Pages;
use App\Models\VehicleVersion;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;

class VehicleVersionResource extends Resource
{
    protected static ?string $model = VehicleVersion::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';
    
    protected static ?string $navigationLabel = 'Lista de Precios';
    
    protected static ?string $pluralLabel = 'Lista de Precios';
    
    protected static ?string $navigationGroup = 'Catálogo';

    public static function getModelLabel(): string
    {
        return 'Versión';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Versiones (Precios)';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('vehicle_model_id')
                    ->relationship('vehicleModel', 'name')
                    ->required(),
                TextInput::make('name')
                    ->label('Nombre de la Versión')
                    ->required(),
                TextInput::make('transmission')
                    ->label('Transmisión'),
                TextInput::make('traction')
                    ->label('Tracción'),
                TextInput::make('fuel')
                    ->label('Combustible'),
                TextInput::make('list_price')
                    ->label('Precio Lista')
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('bonus_price')
                    ->label('Bono Financiamiento')
                    ->numeric()
                    ->prefix('$'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->modifyQueryUsing(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->with([
                'vehicleModel' => fn ($q) => $q->select(['id', 'brand_id', 'name', 'slug', 'category', 'vehicle_type']),
                'vehicleModel.brand'
            ]))
            ->defaultPaginationPageOption(10)
            ->columns([
                TextColumn::make('vehicleModel.brand.name')
                    ->label('Marca')
                    ->badge()
                    ->color('info')
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('vehicleModel.name')
                    ->label('Modelo')
                    ->weight('bold')
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Versión')
                    ->description(fn (\App\Models\VehicleVersion $record): string => $record->transmission ?? '')
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextInputColumn::make('list_price')
                    ->label('Precio Lista')
                    ->type('number')
                    ->sortable()
                    ->extraAttributes(['style' => 'text-align: right; min-width: 120px;', 'class' => 'font-bold text-primary-600']),
                Tables\Columns\TextInputColumn::make('bonus_price')
                    ->label('Precio Bono')
                    ->type('number')
                    ->sortable()
                    ->extraAttributes(['style' => 'text-align: right; min-width: 120px;', 'class' => 'font-bold text-primary-600']),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('CATEGORÍA')
                    ->multiple()
                    ->options([
                        'SUV' => 'SUV',
                        'Sedán' => 'Sedán',
                        'Hatchback' => 'Hatchback',
                        'Pickup' => 'Pickup',
                        'Coupé' => 'Coupé',
                        'Convertible' => 'Convertible',
                        'Van' => 'Van',
                        'Furgón' => 'Furgón',
                        'Camión' => 'Camión',
                        'Moto' => 'Moto',
                    ])
                    ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data): \Illuminate\Database\Eloquent\Builder {
                        return $query->when($data['values'], function ($q) use ($data) {
                            $q->whereHas('vehicleModel', function ($q) use ($data) {
                                foreach ($data['values'] as $value) {
                                    $q->whereJsonContains('category', $value);
                                }
                            });
                        });
                    })
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListVehicleVersions::route('/'),
            'create' => Pages\CreateVehicleVersion::route('/create'),
            'edit' => Pages\EditVehicleVersion::route('/{record}/edit'),
        ];
    }
}