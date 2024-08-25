<?php

namespace App\Filament\Resources\system;
;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\system\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'System';
    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('providers.avatar')
                    ->label('Avatar')
                    ->defaultImageUrl(url('./storage/app/public/media/avatar-placeholder.png'))
                    ->circular(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('providers.provider')
                    ->label('Provider')
                    ->default('email')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'github' => 'warning',
                        'google' => 'success',
                        'email' => 'gray',
                    })
                ,

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Joining Date')
                    ->sortable()
                    ->since(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
