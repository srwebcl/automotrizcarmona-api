<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';
    
    protected static ?string $navigationGroup = 'Marketing';

    protected static ?string $label = 'Banner';
    protected static ?string $pluralLabel = 'Banners';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)->schema([
                    // Columna Izquierda (Archivos y Principal)
                    Forms\Components\Group::make()->columnSpan(2)->schema([
                        Forms\Components\Section::make('Enrutamiento y Título')->schema([
                            Select::make('location')->label('Ubicación del Banner')
                                ->options([
                                    'home_hero' => 'Home Slider Principal',
                                    'home_promotional' => 'Home Sección Destacados (Promocional)',
                                    'servicios' => 'Banner Servicios',
                                    'repuestos' => 'Banner Repuestos',
                                    'dyp' => 'Banner Desabolladura y Pintura',
                                ])
                                ->default('home_hero')
                                ->required()
                                ->live(),

                            TextInput::make('title')
                                ->label('Título Interno o Atributo ALT (Lector de pantalla)')
                                ->required(),

                            TextInput::make('link')->label('Enlace (URL)')
                                ->datalist(function () {
                                    $baseLinks = [
                                        '/',
                                        '/servicios',
                                        '/repuestos',
                                        '/dyp',
                                        '/noticias',
                                        '/nosotros',
                                        '/nuevos/volkswagen',
                                        '/nuevos/toyota',
                                        '/nuevos/audi',
                                        '/nuevos/seat',
                                        '/nuevos/cupra',
                                        '/nuevos/honda',
                                        '/nuevos/bmw',
                                        '/nuevos/maxus',
                                        '/nuevos/geely',
                                        '/nuevos/mg',
                                    ];
                                    
                                    $modelLinks = \App\Models\VehicleModel::with('brand')->get()->map(function($m) {
                                        return '/nuevos/' . $m->brand->slug . '/' . $m->slug;
                                    })->toArray();
                                    
                                    return array_merge($baseLinks, $modelLinks);
                                })
                                ->helperText('Puedes seleccionar una página del sistema, modelo, o escribir un link externo (ej: https://...).')
                                ->columnSpanFull(),
                        ])->columns(2),

                        Forms\Components\Section::make('Archivos Digitales')->schema([
                            FileUpload::make('image_desktop')->label('Imagen Desktop')
                                ->image()
                                ->disk('r2')
                                ->directory('banners')
                                ->required(),
                            FileUpload::make('image_mobile')->label('Imagen Móvil (Opcional)')
                                ->image()
                                ->disk('r2')
                                ->directory('banners'),
                        ])->columns(2),

                        Forms\Components\Section::make('Textos Flotantes (Home Slider)')
                            ->description('Aplica principalmente al Home Slider si el "Mostrar Textos" está activado a la derecha.')
                            ->schema([
                                TextInput::make('subtitle')
                                    ->label('Subtítulo Objeto Flotante')
                                    ->visible(fn (\Filament\Forms\Get $get) => $get('custom_data.show_text')),
                                TextInput::make('custom_data.cta')
                                    ->label('Texto del Botón Flotante')
                                    ->visible(fn (\Filament\Forms\Get $get) => $get('custom_data.show_text')),
                            ])->columns(2),
                    ]),

                    // Columna Derecha (Ajustes y Orden)
                    Forms\Components\Group::make()->columnSpan(1)->schema([
                        Forms\Components\Section::make('Ajustes y Estado')->schema([
                            Toggle::make('active')->label('Activo')
                                ->default(true)
                                ->helperText('Controla la visualización pública en el sitio web.'),

                            Toggle::make('custom_data.show_text')
                                ->label('Mostrar Textos Incrustados')
                                ->helperText('Enciende esta opción para usar el título, subtítulo y botón flotante.')
                                ->default(false)
                                ->live(),
                                
                            TextInput::make('order')->label('Orden de Aparición')
                                ->numeric()
                                ->default(0)
                                ->helperText('Un número menor significa que se mostrará primero.'),
                        ]),
                    ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_desktop')
                    ->label('Imagen')
                    ->disk('r2')
                    ->square(),
                TextColumn::make('title')->label('Título')->searchable(),
                TextColumn::make('location')->label('Ubicación')->sortable()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'home_hero' => 'Home Slider Principal',
                        'home_promotional' => 'Home Sección Destacados (Promocional)',
                        'servicios' => 'Banner Servicios',
                        'repuestos' => 'Banner Repuestos',
                        'dyp' => 'Banner Desabolladura y Pintura',
                        default => $state,
                    })
                    ->badge()
                    ->color('gray'),
                TextColumn::make('order')->label('Orden')->sortable(),
                ToggleColumn::make('active')->label('Estado'),
            ])
            ->filters([])
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
