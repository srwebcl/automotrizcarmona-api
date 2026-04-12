<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    
    protected static ?string $navigationGroup = 'Catálogo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información Básica')
                    ->label('Información de la Marca')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->hidden()
                            ->unique(ignoreRecord: true),
                        FileUpload::make('logo_url')
                            ->label('Logo de la Marca')
                            ->image()
                            ->disk('r2')
                            ->directory('brands/logos'),
                    ])->columns(2),

                Forms\Components\Section::make('Estado')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('¿Marca Activa?')
                            ->default(true),
                    ]),

                Forms\Components\Section::make('Visibilidad Post-Venta')
                    ->label('Mostrar en Formularios')
                    ->description('Habilita el logo de esta marca en los formularios de la web.')
                    ->schema([
                        Forms\Components\Toggle::make('show_in_services')
                            ->label('Servicio Técnico')
                            ->default(true),
                        Forms\Components\Toggle::make('show_in_parts')
                            ->label('Repuestos')
                            ->default(true),
                        Forms\Components\Toggle::make('show_in_dyp')
                            ->label('Desabolladura y Pintura')
                            ->default(true),
                    ])->columns(3),

                Forms\Components\Section::make('Banners Principales')
                    ->label('Slider de Marca (Hero Banners)')
                    ->description('Banners que se muestran en la cabecera de la página de la marca.')
                    ->schema([
                        Repeater::make('hero_banners')
                            ->label('Banners')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Título del Banner'),
                                FileUpload::make('desktop_image')
                                    ->label('Imagen Desktop')
                                    ->image()
                                    ->disk('r2')
                                    ->directory('brands/banners'),
                                FileUpload::make('mobile_image')
                                    ->label('Imagen Mobile')
                                    ->image()
                                    ->disk('r2')
                                    ->directory('brands/banners'),
                            ])
                            ->columns(1)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'Nuevo Banner'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo_url')
                    ->label('Logo')
                    ->disk('r2')
                    ->defaultImageUrl(url('/images/placeholder.png'))
                    ->square(),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Activa')
                    ->boolean(),
                TextColumn::make('slug')
                    ->label('URL'),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Marca';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Marcas';
    }
}
