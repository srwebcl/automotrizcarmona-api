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
    
    protected static ?string $navigationLabel = 'Inventario';
    
    protected static ?string $pluralLabel = 'Inventario';
    
    protected static ?string $navigationGroup = 'Catálogo';

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
                                Select::make('category')
                                    ->label('Categorías')
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
                                    ->preload(),
                                Forms\Components\Fieldset::make('Estado y Etiquetas')
                                    ->schema([
                                        Toggle::make('is_active')->label('Activo')->default(true),
                                        Toggle::make('is_featured')->label('Destacado'),
                                        Toggle::make('is_hybrid')->label('Híbrido'),
                                        Toggle::make('is_electric')->label('Eléctrico'),
                                    ])->columns(4),
                            ])->columns(2),

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
                                            TextInput::make('finance_price')->label('Financio Final')->numeric()->prefix('$')->disabled()->dehydrated(false),
                                        ]),
                                        Forms\Components\Grid::make(4)->schema([
                                            TextInput::make('motor')->label('Motor'),
                                            TextInput::make('power')->label('Potencia'),
                                            TextInput::make('torque')->label('Torque'),
                                            TextInput::make('airbags')->label('Airbags')->numeric(),
                                        ]),
                                        Forms\Components\Grid::make(2)->schema([
                                            TextInput::make('consumption_mixed')->label('Consumo'),
                                            TextInput::make('electric_range')->label('Autonomía'),
                                        ]),
                                    ])->columns(1)->collapsible()
                            ]),

                        Tabs\Tab::make('Equipamiento Destacado')
                            ->icon('heroicon-o-star')
                            ->schema([
                                Repeater::make('features')
                                    ->relationship()
                                    ->schema([
                                        TextInput::make('title')->label('Título'),
                                        Textarea::make('description')->label('Detalle'),
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
                    ->options([
                        'SUV' => 'SUV', 'Sedán' => 'Sedán', 'Hatchback' => 'Hatchback', 'Pickup' => 'Pickup',
                        'Coupé' => 'Coupé', 'Convertible' => 'Convertible', 'Van' => 'Van', 'Furgón' => 'Furgón',
                        'Camión' => 'Camión', 'Moto' => 'Moto'
                    ])
                    ->query(fn ($query, $data) => $query->when($data['values'], fn ($q) => $q->whereJsonContains('category', $data['values']))),
            ])
            ->actions([
                Tables\Actions\EditAction::make('manage_versions')
                    ->label('Versiones')
                    ->icon('heroicon-o-currency-dollar')
                    ->color('success')
                    ->slideOver()
                    ->modalHeading(fn ($record) => "Precios: {$record->name}")
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
                            ])->columns(1)->collapsible()
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
    public static function getPluralModelLabel(): string { return 'Inventario'; }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with(['brand', 'vehicleVersions', 'features']);
    }
}