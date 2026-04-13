<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TruckBrandResource\Pages;
use App\Filament\Resources\TruckBrandResource\RelationManagers;
use App\Models\TruckBrand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TruckBrandResource extends Resource
{
    protected static ?string $model = TruckBrand::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Camiones';
    protected static ?string $modelLabel = 'Marca de Camión';
    protected static ?string $pluralModelLabel = 'Marcas de Camiones';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información Básica')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre de la Marca')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->hidden()
                            ->unique(TruckBrand::class, 'slug', ignoreRecord: true),
                        Forms\Components\FileUpload::make('logo_url')
                            ->label('Logo de la Marca')
                            ->disk('r2')
                            ->directory('truck-brands')
                            ->visibility('public')
                            ->image()
                            ->imageEditor()
                            ->helperText('Sube el logo de la marca directamente a Cloudflare R2.'),
                    ]),

                Forms\Components\Section::make('Estado')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('¿Está activa?')
                            ->default(true)
                            ->required(),
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

                Forms\Components\Section::make('Banners Hero')
                    ->description('Banners que se mostrarán en la parte superior de la página de la marca.')
                    ->schema([
                        Forms\Components\FileUpload::make('hero_banner_desktop')
                            ->label('Banner Desktop')
                            ->disk('r2')
                            ->directory('truck-brands/banners')
                            ->visibility('public')
                            ->image()
                            ->imageEditor()
                            ->helperText('Recomendado: 1920x600px'),
                        Forms\Components\FileUpload::make('hero_banner_mobile')
                            ->label('Banner Mobile')
                            ->disk('r2')
                            ->directory('truck-brands/banners')
                            ->visibility('public')
                            ->image()
                            ->imageEditor()
                            ->helperText('Recomendado: 600x800px'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('logo_url')
                    ->label('Logo')
                    ->disk('r2')
                    ->defaultImageUrl(url('/images/placeholder.png'))
                    ->height(40)
                    ->width(80)
                    ->extraImgAttributes(['style' => 'object-fit: contain; background: white; padding: 4px; border-radius: 6px;']),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTruckBrands::route('/'),
            'create' => Pages\CreateTruckBrand::route('/create'),
            'edit' => Pages\EditTruckBrand::route('/{record}/edit'),
        ];
    }
}
