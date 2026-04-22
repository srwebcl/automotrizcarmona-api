<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleModelResource\Pages;
use App\Models\VehicleModel;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class VehicleModelResource extends Resource
{
    protected static ?string $model = VehicleModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    
    protected static ?string $navigationLabel = 'Modelos';
    
    protected static ?string $pluralLabel = 'Modelos';
    
    protected static ?string $navigationGroup = 'Livianos';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Datos Principales')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Select::make('brand_id')
                                    ->label('Marca')
                                    ->relationship('brand', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                TextInput::make('name')
                                    ->label('Nombre del Modelo')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                                TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->dehydrated()
                                    ->disabled(),
                                Forms\Components\Select::make('category')
                                    ->label('Categorías')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->options(function () {
                                        $existing = \App\Models\VehicleModel::all()->pluck('category')
                                            ->flatten()
                                            ->flatMap(fn ($item) => is_string($item) ? explode(',', $item) : [$item])
                                            ->map(fn ($item) => trim((string) $item))
                                            ->filter()
                                            ->toArray();
                                            
                                        $baseCategories = ['SUV', 'Sedán', 'Hatchback', 'Pickup', 'Coupé', 'Convertible', 'Van', 'Furgón', 'Camión', 'Moto'];
                                        
                                        $merged = collect($baseCategories)
                                            ->merge($existing)
                                            ->map(fn ($item) => \Illuminate\Support\Str::ucfirst($item))
                                            ->unique(fn ($item) => \Illuminate\Support\Str::slug($item))
                                            ->sort()
                                            ->values()
                                            ->toArray();
                                            
                                        return array_combine($merged, $merged);
                                    })
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('new_category')
                                            ->label('Nombre de la Categoría Inédita')
                                            ->required(),
                                    ])
                                    ->createOptionUsing(function (array $data) {
                                        return $data['new_category'];
                                    }),
                                        Forms\Components\Fieldset::make('Estado y Etiquetas')
                                            ->schema([
                                                Toggle::make('includes_iva')->label('Precios Incluyen IVA')->default(true)->columnSpanFull(),
                                                Toggle::make('is_active')->label('Activo')->default(true),
                                                Toggle::make('is_featured')->label('Destacado'),
                                                Toggle::make('is_hybrid')->label('Híbrido'),
                                                Toggle::make('is_electric')->label('Eléctrico'),
                                                Toggle::make('is_promotion')->label('En Promoción')->live(),
                                            ])->columns(5),
                                    ])->columns(2),

                                Tabs\Tab::make('Promociones')
                                    ->icon('heroicon-o-tag')
                                    ->visible(fn (\Filament\Forms\Get $get) => $get('is_promotion'))
                                    ->schema([
                                        Repeater::make('promotionUnits')
                                            ->relationship()
                                            ->schema([
                                                Forms\Components\Grid::make(3)->schema([
                                                    TextInput::make('vin')->label('N° VIN / Chasis')->required(),
                                                     Forms\Components\Select::make('version_name')
                                                        ->label('Seleccionar Versión')
                                                        ->options(function ($get) {
                                                            $modelId = $get('../../id');
                                                            if (!$modelId) return [];
                                                            return \App\Models\VehicleVersion::where('vehicle_model_id', $modelId)->pluck('name', 'name');
                                                        })
                                                        ->required()
                                                        ->live()
                                                        ->afterStateUpdated(function ($state, $set, $get) {
                                                            $modelId = $get('../../id');
                                                            $version = \App\Models\VehicleVersion::where('vehicle_model_id', $modelId)
                                                                ->where('name', $state)
                                                                ->first();
                                                            if ($version) {
                                                                $set('list_price', $version->list_price);
                                                                $set('promo_price', max(0, (int)$version->list_price - (int)$get('promo_bonus')));
                                                            }
                                                        }),
                                                    Toggle::make('is_active')->label('Disponible')->default(true),
                                                ]),
                                                Forms\Components\Grid::make(3)->schema([
                                                     TextInput::make('list_price')
                                                         ->label('Precio Lista ($)')
                                                         ->numeric()
                                                         ->prefix('$')
                                                         ->required()
                                                         ->disabled()
                                                         ->dehydrated()
                                                         ->afterStateHydrated(function ($state, $set, $get) {
                                                            if (!$state || $state == 0) {
                                                                $versionName = $get('version_name');
                                                                $modelId = $get('../../id');
                                                                if ($versionName && $modelId) {
                                                                    $version = \App\Models\VehicleVersion::where('vehicle_model_id', $modelId)
                                                                        ->where('name', $versionName)
                                                                        ->first();
                                                                    if ($version) {
                                                                        $set('list_price', $version->list_price);
                                                                    }
                                                                }
                                                            }
                                                         })
                                                         ->helperText('Se obtiene de la versión original.'),
                                                    TextInput::make('promo_bonus')
                                                        ->label('Bono Liquidación ($)')
                                                        ->numeric()
                                                        ->prefix('$')
                                                        ->required()
                                                        ->live(onBlur: true)
                                                        ->afterStateUpdated(fn ($get, $set) => $set('promo_price', max(0, (int)$get('list_price') - (int)$get('promo_bonus')))),
                                                    TextInput::make('promo_price')
                                                        ->label('Precio Liquidación ($)')
                                                        ->numeric()
                                                        ->prefix('$')
                                                        ->required()
                                                        ->helperText('Se calcula como: Precio Lista - Bono.'),
                                                ]),
                                            ])
                                            ->itemLabel(fn (array $state): ?string => $state['vin'] ?? 'Nueva Unidad'),
                                    ]),

                        Tabs\Tab::make('Multimedia')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                FileUpload::make('thumbnail_url')->label('Miniatura')->image()->disk('r2')->directory('models/thumbnails')->fetchFileInformation(false)->columnSpanFull(),
                                FileUpload::make('desktop_banner_url')->label('Banner Desktop')->image()->disk('r2')->directory('models/banners')->fetchFileInformation(false),
                                FileUpload::make('mobile_banner_url')->label('Banner Mobile')->image()->disk('r2')->directory('models/banners')->fetchFileInformation(false),
                                TextInput::make('video_url')->label('URL de Video')->url()->columnSpanFull(),
                                FileUpload::make('gallery')->label('Galería')->multiple()->image()->disk('r2')->reorderable()->panelLayout('grid')->directory('models/galleries')->fetchFileInformation(false)->columnSpanFull(),
                            ])->columns(2),

                        Tabs\Tab::make('Versiones y Especificaciones')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Repeater::make('vehicleVersions')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\Grid::make(4)->schema([
                                            TextInput::make('name')->label('Versión')->required(),
                                            TextInput::make('transmission')->label('Transmisión'),
                                            TextInput::make('traction')->label('Tracción'),
                                            TextInput::make('fuel')->label('Combustible'),
                                        ]),
                                        Forms\Components\Grid::make(4)->schema([
                                            TextInput::make('list_price')->label('Precio Lista')->numeric()->prefix('$')->live(onBlur: true)
                                                ->afterStateUpdated(fn ($get, $set) => $set('finance_price', max(0, (int)$get('list_price') - (int)$get('brand_bonus') - (int)$get('finance_bonus')))),
                                            TextInput::make('brand_bonus')->label('Bono Marca')->numeric()->prefix('$')->live(onBlur: true)
                                                ->afterStateUpdated(fn ($get, $set) => $set('finance_price', max(0, (int)$get('list_price') - (int)$get('brand_bonus') - (int)$get('finance_bonus')))),
                                            TextInput::make('finance_bonus')->label('Bono Financ.')->numeric()->prefix('$')->live(onBlur: true)
                                                ->afterStateUpdated(fn ($get, $set) => $set('finance_price', max(0, (int)$get('list_price') - (int)$get('brand_bonus') - (int)$get('finance_bonus')))),
                                            TextInput::make('finance_price')->label('Precio Final')->numeric()->prefix('$')->disabled()->dehydrated(false),
                                        ]),
                                        Forms\Components\Grid::make(4)->schema([
                                            TextInput::make('engine')->label('Motor'),
                                            TextInput::make('power_hp')->label('Potencia'),
                                            TextInput::make('torque_nm')->label('Torque'),
                                            TextInput::make('airbags')->label('Airbags')->numeric(),
                                        ]),
                                        Forms\Components\Grid::make(2)->schema([
                                            TextInput::make('mixed_performance')->label('Consumo / Rendimiento'),
                                            TextInput::make('autonomy_km')->label('Autonomía'),
                                        ]),
                                    ])->columns(1)->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? 'Nueva Versión'),
                            ]),

                        Tabs\Tab::make('Equipamiento Destacado')
                            ->icon('heroicon-o-star')
                            ->schema([
                                Repeater::make('features')
                                    ->relationship()
                                    ->schema([
                                        TextInput::make('title')->label('Título')->nullable(),
                                        TextInput::make('description')->label('Detalle')->nullable(),
                                        FileUpload::make('image_url')->label('Icono/Imagen')->image()->disk('r2')->directory('models/features')->fetchFileInformation(false),
                                    ])->collapsible()
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                ImageColumn::make('thumbnail_url')->label('Img')->disk('r2')->square()->size(40),
                TextColumn::make('brand.name')->label('Marca')->badge()->color('info')->sortable(),
                TextColumn::make('name')->label('Modelo')->weight('bold')->searchable()->sortable(),
                TextColumn::make('category')->label('Categoría')->badge()->color('success'),
                TextColumn::make('vehicleVersions.list_price')
                    ->label('Desde')
                    ->money('clp')
                    ->getStateUsing(fn ($record) => $record->vehicleVersions->count() > 0 ? $record->vehicleVersions->min('list_price') : 0),
                ToggleColumn::make('is_active')->label('Activo'),
                ToggleColumn::make('is_featured')->label('Destacado'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('brand_id')->label('Marca')->multiple()->relationship('brand', 'name')->preload(),
                Tables\Filters\SelectFilter::make('category')->label('Categoría')->multiple()
                    ->options(function () {
                        // Recolectar todas las categorías dinámicamente inventadas y predeterminadas
                        $existing = \App\Models\VehicleModel::all()->pluck('category')
                            ->flatten()
                            ->flatMap(fn ($item) => is_string($item) ? explode(',', $item) : [$item])
                            ->map(fn ($item) => trim((string) $item))
                            ->filter()
                            ->toArray();
                            
                        $baseCategories = [
                            'SUV', 'Sedán', 'Hatchback', 'Pickup', 'Coupé', 'Convertible', 'Van', 'Furgón', 'Camión', 'Moto'
                        ];
                        
                        $merged = collect($baseCategories)
                            ->merge($existing)
                            ->map(fn ($item) => \Illuminate\Support\Str::ucfirst($item))
                            ->unique(fn ($item) => \Illuminate\Support\Str::slug($item))
                            ->sort()
                            ->values()
                            ->toArray();
                            
                        return array_combine($merged, $merged);
                    })
                    ->query(fn ($query, $data) => $query->when($data['values'], fn ($q) => $q->whereJsonContains('category', $data['values']))),
            ])
            ->actions([
                Tables\Actions\EditAction::make('manage_versions')
                    ->label('Versiones')
                    ->icon('heroicon-o-currency-dollar')
                    ->color('success')
                    ->slideOver()
                    ->modalHeading(fn ($record) => "Precios y Versiones: {$record->name}")
                    ->form([
                        Forms\Components\Repeater::make('vehicleVersions')
                            ->relationship()
                            ->schema([
                                Forms\Components\Grid::make(4)->schema([
                                    TextInput::make('name')->label('Versión')->required(),
                                    TextInput::make('transmission')->label('Transmisión'),
                                    TextInput::make('traction')->label('Tracción'),
                                    TextInput::make('fuel')->label('Fuel'),
                                ]),
                                Forms\Components\Grid::make(4)->schema([
                                    TextInput::make('list_price')->label('Precio Lista')->numeric()->prefix('$')->live(onBlur: true)
                                        ->afterStateUpdated(fn ($get, $set) => $set('finance_price', max(0, (int)$get('list_price') - (int)$get('brand_bonus') - (int)$get('finance_bonus')))),
                                    TextInput::make('brand_bonus')->label('Bono Marca')->numeric()->prefix('$')->live(onBlur: true)
                                        ->afterStateUpdated(fn ($get, $set) => $set('finance_price', max(0, (int)$get('list_price') - (int)$get('brand_bonus') - (int)$get('finance_bonus')))),
                                    TextInput::make('finance_bonus')->label('Bono Financ.')->numeric()->prefix('$')->live(onBlur: true)
                                        ->afterStateUpdated(fn ($get, $set) => $set('finance_price', max(0, (int)$get('list_price') - (int)$get('brand_bonus') - (int)$get('finance_bonus')))),
                                    TextInput::make('finance_price')->label('Precio Final')->numeric()->prefix('$')->disabled()->dehydrated(false),
                                ]),
                                Forms\Components\Grid::make(4)->schema([
                                    TextInput::make('engine')->label('Motor'),
                                    TextInput::make('power_hp')->label('Potencia'),
                                    TextInput::make('torque_nm')->label('Torque'),
                                    TextInput::make('mixed_performance')->label('Consumo'),
                                ]),
                            ])->columns(1)->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? 'Nueva Versión'),
                    ]),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVehicleModels::route('/'),
            'create' => Pages\CreateVehicleModel::route('/create'),
            'edit' => Pages\EditVehicleModel::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string { return 'Modelo'; }
    public static function getPluralModelLabel(): string { return 'Modelos'; }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with(['brand', 'vehicleVersions', 'features']);
    }
}