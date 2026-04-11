<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchResource\Pages;
use App\Models\Branch;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    
    protected static ?string $navigationGroup = 'Empresa';

    protected static ?string $label = 'Sucursal';
    protected static ?string $pluralLabel = 'Sucursales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información de la Sucursal')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre de Sucursal')
                            ->placeholder('Ej: Sala de Ventas Talca')
                            ->required(),
                        Select::make('type')
                            ->label('Tipo de Sucursal')
                            ->options([
                                'Sala de Ventas' => 'Sala de Ventas',
                                'Servicio Técnico' => 'Servicio Técnico',
                                'Repuestos' => 'Repuestos',
                                'Desabolladura y Pintura' => 'Desabolladura y Pintura',
                            ])
                            ->required(),
                        Select::make('brands')
                            ->label('Marcas que atiende')
                            ->multiple()
                            ->relationship('brands', 'name')
                            ->searchable(),
                    ])->columns(2),

                Section::make('Ubicación y Contacto')
                    ->schema([
                        TextInput::make('address')->label('Dirección')->required(),
                        TextInput::make('city')->label('Ciudad')->required(),
                        TextInput::make('manager_name')->label('Jefe de Sucursal / Contacto'),
                        TextInput::make('phone')->label('Teléfono'),
                        TextInput::make('email')->label('Email')->email(),
                        Textarea::make('schedule')
                            ->label('Horario de Atención')
                            ->rows(3),
                        Textarea::make('map_link')
                            ->label('Link Google Maps (Iframe o URL)')
                            ->rows(3),
                    ])->columns(2),

                Section::make('Imagen de Sucursal')
                    ->schema([
                        TextInput::make('image_url')
                            ->label('URL Imagen Sucursal')
                            ->url()
                            ->placeholder('https://...')
                            ->helperText('Pega la URL de una imagen (desde Cloudflare R2 u otra fuente).'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Foto')
                    ->disk('r2')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge(),
                TextColumn::make('city')
                    ->label('Ciudad')
                    ->sortable(),
                TextColumn::make('brands.name')
                    ->label('Marcas')
                    ->badge(),
                TextColumn::make('phone')
                    ->label('Teléfono'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'Sala de Ventas' => 'Sala de Ventas',
                        'Servicio Técnico' => 'Servicio Técnico',
                        'Repuestos' => 'Repuestos',
                        'Desabolladura y Pintura' => 'Desabolladura y Pintura',
                    ]),
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
            'index' => Pages\ListBranches::route('/'),
            'create' => Pages\CreateBranch::route('/create'),
            'edit' => Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}
