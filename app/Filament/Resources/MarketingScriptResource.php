<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MarketingScriptResource\Pages;
use App\Models\MarketingScript;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MarketingScriptResource extends Resource
{
    protected static ?string $model = MarketingScript::class;

    protected static ?string $navigationIcon  = 'heroicon-o-code-bracket';
    protected static ?string $navigationGroup = 'Configuraciones';
    protected static ?string $label           = 'Script de Marketing';
    protected static ?string $pluralLabel     = 'Scripts de Marketing';
    protected static ?int    $navigationSort  = 99;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(3)->schema([

                // ── Columna principal ────────────────────────────────────
                Forms\Components\Group::make()->columnSpan(2)->schema([

                    Forms\Components\Section::make('Configuración del Script')->schema([

                        Forms\Components\TextInput::make('name')
                            ->label('Nombre interno')
                            ->placeholder('Ej: Google Tag Manager — Producción')
                            ->helperText('Solo visible en este panel. Úsalo para identificar el script.')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Select::make('type')
                            ->label('Herramienta de Marketing')
                            ->options(MarketingScript::typeLabels())
                            ->default('gtm')
                            ->required()
                            ->live()
                            ->columnSpanFull(),

                        // ── Campo de valor (dinámico según tipo) ──────────
                        Forms\Components\Textarea::make('value')
                            ->label(fn (Get $get): string => match ($get('type')) {
                                'custom' => 'Código HTML del Script',
                                default  => 'ID / Código de Seguimiento',
                            })
                            ->helperText(fn (Get $get): string =>
                                MarketingScript::typeHints()[$get('type') ?? 'custom'] ?? ''
                            )
                            ->rows(fn (Get $get): int => $get('type') === 'custom' ? 8 : 2)
                            ->placeholder(fn (Get $get): string => match ($get('type')) {
                                'gtm'        => 'GTM-XXXXX',
                                'ga4'        => 'G-XXXXXXXXXX',
                                'google_ads' => 'AW-XXXXXXXXX',
                                'meta_pixel' => '123456789012345',
                                'hotjar'     => '1234567',
                                'clarity'    => 'abcde12345',
                                'custom'     => '<script>/* tu código aquí */</script>',
                                default      => '',
                            })
                            ->required()
                            ->columnSpanFull(),

                        // ── Placement (solo visible para 'custom') ────────
                        Forms\Components\Select::make('placement')
                            ->label('Ubicación de inyección')
                            ->options([
                                'head'       => '<head> — Encabezado de la página',
                                'body_start' => 'Inicio de <body>',
                                'body_end'   => 'Final de <body> (Recomendado para la mayoría)',
                            ])
                            ->default('head')
                            ->visible(fn (Get $get): bool => $get('type') === 'custom')
                            ->helperText('Para herramientas estándar (GTM, GA4, etc.) la ubicación se asigna automáticamente.')
                            ->required(fn (Get $get): bool => $get('type') === 'custom')
                            ->columnSpanFull(),

                    ])->columns(2),

                ]),

                // ── Columna lateral (estado y orden) ────────────────────
                Forms\Components\Group::make()->columnSpan(1)->schema([

                    Forms\Components\Section::make('Estado')->schema([

                        Forms\Components\Toggle::make('is_active')
                            ->label('Script Activo')
                            ->default(true)
                            ->helperText('Desactívalo para pausarlo sin eliminarlo. Los cambios se propagan en hasta 1 hora.'),

                        Forms\Components\TextInput::make('order')
                            ->label('Orden de carga')
                            ->numeric()
                            ->default(0)
                            ->helperText('Número menor = carga antes. GTM generalmente va en orden 1.'),

                    ]),

                    Forms\Components\Section::make('ℹ️ Guía rápida')->schema([
                        Forms\Components\Placeholder::make('guide')
                            ->label('')
                            ->content(fn (Get $get): string => match ($get('type')) {
                                'gtm'        => '🏷️ GTM: Si ya usas Google Tag Manager, puedes gestionar GA4, Meta Pixel y Google Ads desde el container de GTM sin agregar más scripts aquí.',
                                'ga4'        => '📊 GA4: Agrega este script SOLO si no estás usando GTM. Si ya tienes GTM, configura GA4 dentro del container.',
                                'hotjar'     => '🔥 Hotjar: Carga en segundo plano (lazy). No afecta la velocidad de carga inicial del sitio.',
                                'clarity'    => '🔍 Clarity: Gratis e ilimitado. Alternativa a Hotjar para mapas de calor y grabaciones de sesión.',
                                'meta_pixel' => '📘 Meta Pixel: Necesario para campañas en Facebook e Instagram Ads. Permite rastrear conversiones.',
                                'google_ads' => '🎯 Google Ads: Solo necesario si haces campañas en Google Ads y quieres medir conversiones en el sitio.',
                                'custom'     => '⚠️ Script personalizado: Pega el código completo tal como te lo entrega el proveedor. Asegúrate de incluir las etiquetas <script>.',
                                default      => 'Selecciona una herramienta para ver la guía.',
                            }),
                    ]),

                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('type')
                    ->label('Herramienta')
                    ->formatStateUsing(fn (string $state): string =>
                        MarketingScript::typeLabels()[$state] ?? $state
                    )
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'gtm'        => 'warning',
                        'ga4'        => 'success',
                        'google_ads' => 'danger',
                        'meta_pixel' => 'primary',
                        'hotjar'     => 'danger',
                        'clarity'    => 'info',
                        'custom'     => 'gray',
                        default      => 'gray',
                    }),

                Tables\Columns\TextColumn::make('value')
                    ->label('ID / Código')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->value),

                Tables\Columns\TextColumn::make('placement')
                    ->label('Ubicación')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'head'       => '〈head〉',
                        'body_start' => 'Inicio 〈body〉',
                        'body_end'   => 'Final 〈body〉',
                        default      => $state,
                    })
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('order')
                    ->label('Orden')
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Activo'),
            ])
            ->defaultSort('order')
            ->reorderable('order')
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
            'index'  => Pages\ListMarketingScripts::route('/'),
            'create' => Pages\CreateMarketingScript::route('/create'),
            'edit'   => Pages\EditMarketingScript::route('/{record}/edit'),
        ];
    }
}
