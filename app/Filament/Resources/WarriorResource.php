<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WarriorResource\Pages;
use App\Filament\Resources\WarriorResource\RelationManagers;
use App\Models\Warrior;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WarriorResource extends Resource
{
    protected static ?string $model = Warrior::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('chat_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('telegram_nick')
                    ->maxLength(255),
                Forms\Components\Select::make('role_id')
                    ->relationship('role', 'name')
                    ->default(1),
                Forms\Components\Select::make('group_id')
                    ->relationship('group', 'name')
                    ->default(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('chat_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telegram_nick')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('group.name')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListWarriors::route('/'),
            'create' => Pages\CreateWarrior::route('/create'),
            'edit' => Pages\EditWarrior::route('/{record}/edit'),
        ];
    }
}
