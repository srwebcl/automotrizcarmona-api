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
                                    ->required()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Nombre de Marca')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                                        Forms\Components\TextInput::make('slug')
                                            ->label('Slug')
                                            ->required()
                                            ->unique('brands', 'slug'),
                                    ])
                                    ->createOptionModalHeading('Añadir Nueva Marca'),
                                TextInput::make('name')
                                    ->label('Nombre del Modelo')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                                TextInput::make('slug')
                                    ->label('Slug / URL')
                                    ->required()
                                    ->readOnly()
                                    ->unique(ignoreRecord: true),
                                TextInput::make('slogan')
                                    ->label('Eslogan (Slogan)'),
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
                                Select::make('vehicle_type')
                                    ->label('Tipo de Vehículo')
                                    ->options([
                                        'auto' => 'Automóvil / SUV / Camioneta',
                                        'camion' => 'Camión / Maquinaria / Comercial',
                                    ])
                                    ->default('auto')
                                    ->required()
                                    ->prefixIcon('heroicon-o-truck'),
                                Forms\Components\Fieldset::make('Estado y Etiquetas del Vehículo')
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Público en Catálogo')
                                            ->helperText('Visible para los clientes.')
                                            ->default(true),
                                        Toggle::make('is_featured')
                                            ->label('Auto Destacado')
                                            ->helperText('Mostrar en el Home.'),
                                        Toggle::make('is_hybrid')
                                            ->label('Híbrido'),
                                        Toggle::make('is_electric')
                                            ->label('Eléctrico'),
                                    ])
                                    ->columns(5)
                                    ->columnSpanFull(),
                                Textarea::make('description')
                                    ->label('Descripción Principal')
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Tabs\Tab::make('Multimedia')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                FileUpload::make('thumbnail_url')
                                    ->label('Miniatura (Thumbnail)')
                                    ->image()
                                    ->disk('r2')
                                    ->directory('models/thumbnails')
                                    ->fetchFileInformation(false)
                                    ->columnSpanFull(),
                                FileUpload::make('desktop_banner_url')
                                    ->label('Banner Desktop')
                                    ->image()
                                    ->disk('r2')
                                    ->directory('models/banners')
                                    ->fetchFileInformation(false),
                                FileUpload::make('mobile_banner_url')
                                    ->label('Banner Mobile')
                                    ->image()
                                    ->disk('r2')
                                    ->directory('models/banners')
                                    ->fetchFileInformation(false),
                                TextInput::make('video_url')
                                    ->label('URL de Video (YouTube/Vimeo)')
                                    ->url()
                                    ->placeholder('https://www.youtube.com/...')
                                    ->columnSpanFull(),
                                FileUpload::make('gallery')
                                    ->label('Galería de Imágenes')
                                    ->multiple()
                                    ->image()
                                    ->disk('r2')
                                    ->reorderable()
                                    ->panelLayout('grid')
                                    ->directory('models/galleries')
                                    ->fetchFileInformation(false)
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Tabs\Tab::make('Versiones y Precios')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Repeater::make('vehicleVersions')
                                    ->label('Versiones del Modelo')
                                    ->relationship()
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Nombre de Versión')
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
                                        TextInput::make('finance_bonus')
                                            ->label('Bono Financiamiento')
                                            ->numeric()
                                            ->prefix('$'),
                                    ])
                                    ->columns(2)
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? 'Nueva Versión'),
                            ]),

                        Tabs\Tab::make('Equipamiento Destacado')
                            ->icon('heroicon-o-star')
                            ->schema([
                                Repeater::make('features')
                                    ->label('Características')
                                    ->relationship()
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Título de Característica')
                                            ->required(),
                                        Textarea::make('description')
                                            ->label('Descripción / Detalle'),
                                        FileUpload::make('image_url')
                                            ->label('Imagen / Icono')
                                            ->image()
                                            ->disk('r2')
                                            ->directory('models/features')
                                            ->fetchFileInformation(false),
                                    ])
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'Nueva Característica'),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->defaultPaginationPageOption(10)
            ->columns([
                ImageColumn::make('thumbnail_url')
                    ->label('Imagen')
                    ->disk('r2')
                    ->defaultImageUrl(url('/images/placeholder.png'))
                    ->square()
                    ->size(40)
                    ->extraImgAttributes(['loading' => 'lazy']),
                TextColumn::make('brand.name')
                    ->label('Marca')
                    ->badge()
                    ->color('info')
                    ->wrap()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Modelo')
                    ->weight('bold')
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->label('Categoría')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                TextColumn::make('vehicleVersions.list_price')
                    ->label('Precio (Desde)')
                    ->money('clp')
                    ->getStateUsing(function (\App\Models\VehicleModel $record) {
                        return $record->vehicleVersions->count() > 0 
                            ? $record->vehicleVersions->min('list_price') 
                            : 0;
                    })
                    ->sortable(),
                TextColumn::make('vehicle_type')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'auto' => 'info',
                        'camion' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'auto' => 'Auto/SUV',
                        'camion' => 'Camión',
                        default => $state,
                    })
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Activo')
                    ->sortable(),
                ToggleColumn::make('is_featured')
                    ->label('Destacado')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('brand_id')
                    ->label('MARCA')
                    ->multiple()
                    ->relationship('brand', 'name')
                    ->preload(),
                Tables\Filters\SelectFilter::make('vehicle_type')
                    ->label('TIPO')
                    ->options([
                        'auto' => 'Auto/SUV',
                        'camion' => 'Camión Comercial',
                    ]),
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
                            foreach ($data['values'] as $value) {
                                $q->whereJsonContains('category', $value);
                            }
                        });
                    })
                    ->preload(),
                Tables\Filters\Filter::make('equipment')
                    ->label('EQUIPAMIENTO')
                    ->form([
                        Forms\Components\Toggle::make('is_hybrid')
                            ->label('Híbrido'),
                        Forms\Components\Toggle::make('is_electric')
                            ->label('Eléctrico'),
                    ])
                    ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data): \Illuminate\Database\Eloquent\Builder {
                        return $query->when($data['is_hybrid'], fn ($q) => $q->where('is_hybrid', true))
                                     ->when($data['is_electric'], fn ($q) => $q->where('is_electric', true));
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make('manage_versions')
                    ->label('Versiones')
                    ->icon('heroicon-o-currency-dollar')
                    ->color('success')
                    ->slideOver()
                    ->url(null)
                    ->modalHeading(fn (\App\Models\VehicleModel $record) => "Precios y Versiones de {$record->name}")
                    ->form([
                        Forms\Components\Repeater::make('vehicleVersions')
                            ->label('Versiones del Modelo')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nombre de Versión')
                                    ->required(),
                                Forms\Components\TextInput::make('transmission')
                                    ->label('Transmisión'),
                                Forms\Components\TextInput::make('traction')
                                    ->label('Tracción'),
                                Forms\Components\TextInput::make('fuel')
                                    ->label('Combustible'),
                                Forms\Components\TextInput::make('list_price')
                                    ->label('Precio Lista')
                                    ->numeric()
                                    ->prefix('$'),
                                Forms\Components\TextInput::make('finance_bonus')
                                    ->label('Bono Financiamiento')
                                    ->numeric()
                                    ->prefix('$'),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->addActionLabel('Añadir Versión')
                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? 'Nueva Versión'),
                    ]),
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
            'index' => Pages\ListVehicleModels::route('/'),
            'create' => Pages\CreateVehicleModel::route('/create'),
            'edit' => Pages\EditVehicleModel::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Modelo de Vehículo';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Modelos de Vehículos';
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->with(['brand', 'vehicleVersions', 'features']);
    }
}