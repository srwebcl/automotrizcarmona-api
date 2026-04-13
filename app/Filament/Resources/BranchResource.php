<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchResource\Pages;
use App\Models\Branch;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = 'Configuraciones';
    protected static ?string $label = 'Sucursal';
    protected static ?string $pluralLabel = 'Sucursales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // ── INFORMACIÓN BÁSICA ──────────────────────────────────────────
                Section::make('Información de la Sucursal')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre de Sucursal')
                            ->placeholder('Ej: Sala de Ventas Toyota La Serena')
                            ->required(),
                        Select::make('type')
                            ->label('Tipo de Sucursal')
                            ->options([
                                'Sala de Ventas'          => 'Sala de Ventas',
                                'Servicio Técnico'        => 'Servicio Técnico',
                                'Repuestos'               => 'Repuestos',
                                'Desabolladura y Pintura' => 'Desabolladura y Pintura',
                            ])
                            ->required(),
                    ])->columns(2),

                // ── MARCAS ──────────────────────────────────────────────────────
                Section::make('Marcas que atiende')
                    ->description('Selecciona las marcas que esta sucursal atiende.')
                    ->schema([
                        Select::make('brands_list')
                            ->label('Marcas')
                            ->multiple()
                            ->searchable()
                            ->placeholder('Ej: Toyota, Volkswagen, Iveco...')
                            ->options([
                                'Toyota' => 'Toyota', 'Volkswagen' => 'Volkswagen', 'Audi' => 'Audi', 'Seat' => 'Seat', 'Cupra' => 'Cupra',
                                'Honda' => 'Honda', 'BMW' => 'BMW', 'BMW Motorrad' => 'BMW Motorrad', 'Mini' => 'Mini', 'MG' => 'MG',
                                'Maxus' => 'Maxus', 'Jetour' => 'Jetour', 'Geely' => 'Geely', 'Dongfeng' => 'Dongfeng', 'Kaiyi' => 'Kaiyi',
                                'Karry' => 'Karry', 'Foton' => 'Foton', 'Iveco' => 'Iveco', 'MAN' => 'MAN',
                                'VW Camiones' => 'VW Camiones', 'Foton Camiones' => 'Foton Camiones',
                            ]),
                    ]),

                // ── UBICACIÓN Y CONTACTO ────────────────────────────────────────
                Section::make('Ubicación y Contacto')
                    ->schema([
                        TextInput::make('address')
                            ->label('Dirección')
                            ->placeholder('Ej: Av. Balmaceda 3681')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                $city = $get('city') ?? '';
                                if ($state) {
                                    $set('map_link', 'https://maps.google.com/?q=' . urlencode(trim($state . ', ' . $city)));
                                }
                            }),

                        TextInput::make('city')
                            ->label('Ciudad')
                            ->placeholder('Ej: La Serena')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                $address = $get('address') ?? '';
                                if ($address) {
                                    $set('map_link', 'https://maps.google.com/?q=' . urlencode(trim($address . ', ' . $state)));
                                }
                            }),

                        TextInput::make('manager_name')
                            ->label('Jefe de Sucursal / Contacto'),

                        TextInput::make('phone')
                            ->label('Teléfono')
                            ->placeholder('+56 9 1234 5678'),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->placeholder('sucursal@carmonaycia.cl'),

                        // ── HORARIO ─────────────────────────────────────────────
                        Select::make('schedule')
                            ->label('Horario de Atención')
                            ->options([
                                'L-V: 09:30 a 19:00 | Sáb: 10:00 a 13:30'  => 'L-V: 09:30 a 19:00 | Sáb: 10:00 a 13:30',
                                'L-V: 08:30 a 18:00'                       => 'L-V: 08:30 a 18:00',
                            ])
                            ->searchable()
                            ->createOptionForm([
                                TextInput::make('schedule')
                                    ->label('Horario personalizado')
                                    ->placeholder('L-V: 9:00 a 18:00 | Sáb: 9:00 a 13:00')
                                    ->required(),
                            ])
                            ->createOptionUsing(fn (array $data) => $data['schedule'])
                            ->helperText('Selecciona un horario predefinido o escribe uno nuevo con "Crear".'),

                        // ── GOOGLE MAPS ────────────────────────────────────────
                        TextInput::make('map_link')
                            ->label('Link Google Maps (generado automáticamente)')
                            ->url()
                            ->placeholder('https://maps.google.com/?q=...')
                            ->helperText('Se completa solo al ingresar la dirección. Puedes ajustarlo manualmente.')
                            ->columnSpanFull(),
                    ])->columns(2),

                // ── IMAGEN ──────────────────────────────────────────────────────
                Section::make('Imagen de Sucursal')
                    ->schema([
                        FileUpload::make('image_url')
                            ->label('Foto de la Sucursal')
                            ->image()
                            ->disk('r2')
                            ->directory('branches')
                            ->visibility('public')
                            ->imageEditor()
                            ->helperText('Sube la foto de la sucursal directamente a Cloudflare R2.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                TextColumn::make('brands_list')
                    ->label('Marcas')
                    ->badge()
                    ->separator(','),
                TextColumn::make('phone')
                    ->label('Teléfono'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'Sala de Ventas'          => 'Sala de Ventas',
                        'Servicio Técnico'        => 'Servicio Técnico',
                        'Repuestos'               => 'Repuestos',
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
            'index'  => Pages\ListBranches::route('/'),
            'create' => Pages\CreateBranch::route('/create'),
            'edit'   => Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}
