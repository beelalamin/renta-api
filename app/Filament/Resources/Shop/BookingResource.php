<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop\BookingResource\Pages;
use App\Filament\Resources\Shop\BookingResource\RelationManagers;
use App\Models\Shop\Booking;
use App\Models\shop\Customer;
use App\Models\shop\Payment;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use function Pest\Laravel\options;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationGroup = 'Order Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                // Booking Information
                Forms\Components\Grid::make(2),
                Section::make('Booking Information')
                    ->icon('heroicon-m-shopping-bag')
                    ->description('Fill the correct booking information')
                    ->columns([
                        'sm' => 1,
                        'xl' => 2,
                        '2xl' => 2,
                    ])
                    ->schema([
                        Forms\Components\Select::make('customer_id')
                            ->label('Customer')
                            ->options(Customer::with('user')->get()->pluck('user.name', 'id'))
                            ->preload()
                            ->searchable(),
                        Forms\Components\Select::make('vehicle_id')
                            ->label('Vehicle')
                            ->relationship('vehicle', 'title')
                            ->preload()
                            ->searchable(),
                        Forms\Components\Select::make('type')
                            ->options([
                                'rental' => 'Rental',
                                'subscription' => 'Subscription',
                            ])
                            ->native(false)
                            ->required(),
                        Forms\Components\Select::make('protection')
                            ->options([
                                'standard' => 'Standard',
                                'advance' => 'Advance',
                            ])
                            ->native(false)
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->options([
                                'processing' => 'Processing',
                                'deliverd' => 'Delivered',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->columnSpanFull()
                            ->native(false),
                    ]),

                // Payment & Billing
                Section::make('Payment & Billing')
                    ->columns([
                        'sm' => 1,
                        'xl' => 2,
                        '2xl' => 2,
                    ])
                    ->description('Enter the payment & Billing Details')
                    ->icon('heroicon-m-banknotes')

                    ->schema([
                        Forms\Components\TextInput::make('total_amount')
                            ->required()
                            ->prefix('QAR')
                            ->numeric(),

                        Forms\Components\Select::make('payment_id')
                            ->options(Payment::all()->pluck('transaction_id', 'id'))
                            ->label('Payment')
                            ->unique()
                            ->preload()
                            ->searchable(),


                        Forms\Components\Select::make('location_id')
                            ->relationship('location', 'name')
                            ->searchable()
                            ->preload()
                            ->columnSpanFull()
                            ->label('Pickup Location')
                            ->native(false),
                        Forms\Components\DateTimePicker::make('pickup_at')
                            ->label('Pickup Date & Time')
                            ->minDate(now())
                            ->maxDate(now()->addMonth())
                            ->default(now())
                            ->required(),
                        Forms\Components\DateTimePicker::make('return_at')
                            ->label('Return Date & Time')
                            ->minDate(now())
                            ->maxDate(now()->addMonth())
                            ->required(),
                    ]),


                // Additional Information
                Section::make('Additional Information')
                    ->icon('heroicon-m-information-circle')
                    ->description('Prevent abuse by limiting the number of requests per period')
                    ->columns([
                        'sm' => 1,
                        'xl' => 2,
                        '2xl' => 2,
                    ])
                    ->schema([
                        Forms\Components\Select::make('Milage')
                            ->options([
                                'unlimited' => 'Unlimited',
                                '1500' => '< 1500',
                                '800' => '< 800',
                            ])
                            ->required()
                            ->native(false)
                            ->suffix('Miles'),

                        Forms\Components\TextInput::make('infant_seat')
                            ->maxValue(4)
                            ->required()
                            ->numeric()
                            ->suffix('Seats'),

                        Forms\Components\Toggle::make('additional_driver')
                            ->default(false),
                    ]),






            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.user.name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('vehicle.title'),
                Tables\Columns\TextColumn::make('status')->badge()->color(fn(string $state): string => match ($state) { 'processing' => 'warning', 'success' => 'success', 'failed' => 'danger',
                }),
                Tables\Columns\TextColumn::make('total_amount')->numeric()->money('QAR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('protection'),
                Tables\Columns\TextColumn::make('location.name')->label('Pickup Location')->searchable(),
                Tables\Columns\TextColumn::make('pickup_at')->label('Pickup Date & Time')->dateTime(),
                Tables\Columns\TextColumn::make('return_at')->label('Return Date & Time')->dateTime(),
                Tables\Columns\TextColumn::make('payment.transaction_id')->label('Transaction Id'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'view' => Pages\ViewBooking::route('/{record}'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
