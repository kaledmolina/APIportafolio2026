<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Filament\Resources\LeadResource\RelationManagers;
use App\Models\Lead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Interesado';
    protected static ?string $pluralModelLabel = 'Interesados';
    protected static ?string $navigationLabel = 'Interesados';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('subject')
                    ->label('Asunto')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('message')
                    ->label('Mensaje')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->label('Estado')
                    ->options([
                        'new' => 'Nuevo',
                        'contacted' => 'Contactado',
                        'converted' => 'Convertido',
                        'archived' => 'Archivado',
                    ])
                    ->required()
                    ->default('new'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Asunto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'new' => 'Nuevo',
                        'contacted' => 'Contactado',
                        'converted' => 'Convertido',
                        'archived' => 'Archivado',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'new' => 'info',
                        'contacted' => 'warning',
                        'converted' => 'success',
                        'archived' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Registro')
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
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
