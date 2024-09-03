<?php

namespace App\Filament\Resources\Shop\BookingResource\RelationManagers;

use App\Models\Shop\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('booking_id')
                    ->default(fn(RelationManager $livewire) => $livewire->ownerRecord->id)
                    ->readOnly()
                    ->required(),
                Forms\Components\TextInput::make('user_id')
                    ->default(fn(RelationManager $livewire) => $livewire->ownerRecord->user_id)
                    ->readOnly()
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->prefix('QAR')
                    ->label('Total Amount')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'success' => 'Success',
                        'failed' => 'Failed',
                    ])
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('method')
                    ->options([
                        'cash_on_delivery' => 'Cash On Delivery',
                        'credit_card' => 'Credit Card',
                    ])
                    ->native(false)
                    ->required(),
                Forms\Components\TextInput::make('booking_id'),
                Forms\Components\TextInput::make('transaction_id')
                    ->unique(Payment::class, 'transaction_id', ignoreRecord: true)
                    ->required(),
                Forms\Components\Toggle::make('recurrent')
                    ->default(false),


            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('booking_id')
            ->columns([
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->prefix('QAR ')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'success' => 'success',
                        'failed' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('method'),
                Tables\Columns\TextColumn::make('transaction_id'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Paid at'),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
