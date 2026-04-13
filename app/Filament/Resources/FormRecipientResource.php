<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormRecipientResource\Pages;
use App\Models\FormRecipient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FormRecipientResource extends Resource
{
    protected static ?string $model = FormRecipient::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Emails Formularios';
    protected static ?string $modelLabel = 'Configuración de Destinatario';
    protected static ?string $pluralModelLabel = 'Emails de Formularios';
    protected static ?string $navigationGroup = 'Configuraciones';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Configurar Destinatarios')
                    ->description('Gestiona quiénes reciben los correos de los formularios del sitio web que no pasan por Tecnom.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Formulario')
                            ->disabled()
                            ->required(),
                        Forms\Components\TagsInput::make('emails')
                            ->label('Correos Electrónicos')
                            ->placeholder('Nuevo correo')
                            ->helperText('Agrega los correos que deben recibir notificaciones y presiona Enter o Coma.')
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Formulario')
                    ->searchable(),
                Tables\Columns\TagsColumn::make('emails')
                    ->label('Correos Destinatarios'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFormRecipients::route('/'),
            'edit' => Pages\EditFormRecipient::route('/{record}/edit'),
        ];
    }
    
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }
}
