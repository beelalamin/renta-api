<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\BookingResource\RelationManagers\PaymentsRelationManager;
use App\Filament\Resources\Shop\PaymentResource\Pages;
use App\Models\Shop\Payment;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Order Management';
    protected static ?int $navigationSort = 3;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Customer')
                    //->options(User::all()->pluck('name', 'id'))
                    ->relationship('user', 'name')
                    ->required()
                    ->native(false)
                    ->searchable()
                    ->preload(),
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
                Section::make('Subscription')
                    ->description('Toggle for subscription only')
                    ->schema([
                        Forms\Components\Toggle::make('recurrent')
                            ->default(false),

                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer'),
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
                Tables\Columns\TextColumn::make('method')
                    ->searchable(),
                Tables\Columns\IconColumn::make('recurrent')
                    ->boolean(),
                Tables\Columns\TextColumn::make('transaction_id')
                    ->searchable(),
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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'view' => Pages\ViewPayment::route('/{record}'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
