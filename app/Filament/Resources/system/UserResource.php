<?php

namespace App\Filament\Resources\System;
;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\system\UserResource\Pages;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

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
                Forms\Components\TextInput::make('country'),
                Forms\Components\TextInput::make('state')
                    ->required(),
                Forms\Components\TextInput::make('city')
                    ->required(),
                Forms\Components\TextInput::make('street_address')
                    ->required(),
                Forms\Components\TextInput::make('flight_number'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('providers.avatar')
                    ->label('Avatar')
                    ->defaultImageUrl(asset('storage/media/avatar-placeholder.png'))
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
                    }),
                // Tables\Columns\TextColumn::make('country'),
                // Tables\Columns\TextColumn::make('state')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('city')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('street_address')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('flight_number')
                //     ->searchable(),

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
