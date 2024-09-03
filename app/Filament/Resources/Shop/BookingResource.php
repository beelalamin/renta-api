<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop\BookingResource\Pages;
use App\Models\Shop\Booking;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Enums\BookingStatus;
use App\Filament\Resources\Shop\BookingResource\RelationManagers\PaymentsRelationManager;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Split;


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
                        Forms\Components\TextInput::make('booking_number')
                            ->default('BKN-' . random_int(100000, 999999))
                            ->readOnly()
                            ->dehydrated()
                            ->required()
                            ->maxLength(32)
                            ->unique(Booking::class, 'booking_number', ignoreRecord: true),
                        Forms\Components\Select::make('user_id')
                            ->label('Customer')
                            ->options(User::all()->pluck('name', 'id'))
                            ->preload()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(fn(callable $set) => $set('payments', null)),
                        Forms\Components\Select::make('vehicle_id')
                            ->label('Vehicle')
                            ->relationship('vehicle', 'title')
                            ->preload()
                            ->searchable(),
                        Forms\Components\Select::make('booking_type')
                            ->options([
                                'rental' => 'Rental',
                                'subscription' => 'Subscription',
                            ])
                            ->default('rental')
                            ->native(false)
                            ->reactive()
                            ->required(),
                        Forms\Components\ToggleButtons::make('status')
                            ->inline()
                            ->default('new')
                            ->options(BookingStatus::class)
                            ->columnSpanFull()
                            ->required(),
                    ]),

                // Subscription Details
                Split::make([
                    Section::make('Additional Information')
                        ->icon('heroicon-m-information-circle')
                        ->description('Prevent abuse by limiting the number of requests per period')
                        ->columns(2)
                        ->collapsible()
                        ->schema([

                            Forms\Components\Select::make('pickup_location_id')
                                ->label('Pickup Location')
                                ->relationship('pickupLocation', 'name')
                                ->searchable()
                                ->preload()
                                ->native(false),
                            Forms\Components\Select::make('return_location_id')
                                ->label('Return Location')
                                ->relationship('returnLocation', 'name')
                                ->searchable()
                                ->preload()
                                ->native(false),
                            Forms\Components\DateTimePicker::make('pickup_date')
                                ->label('Pickup Date & Time')
                                ->minDate(now())
                                ->maxDate(now()->addMonth())
                                ->default(now())
                                ->required(),
                            Forms\Components\DateTimePicker::make('return_date')
                                ->label('Return Date & Time')
                                ->minDate(now())
                                ->maxDate(now()->addMonth())
                                ->required(),

                            Forms\Components\Select::make('protection')
                                ->options([
                                    'basic' => 'Basic',
                                    'partial' => 'Partial',
                                    'full' => 'Full',
                                ])
                                ->default('basic')
                                ->native(false)
                                ->required(),
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
                                ->numeric()
                                ->suffix('Seats'),

                            Forms\Components\Textarea::make('note')
                                ->label('Customer Note')
                                ->columnSpanFull(),
                        ]),

                    Section::make([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at:')
                            ->visible(fn($record) => $record !== null)
                            ->content(fn(callable $get): ?string => optional($get('created_at'))->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at:')
                            ->visible(fn($record) => $record !== null)
                            ->content(fn(callable $get): ?string => optional($get('updated_at'))->diffForHumans()),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        Forms\Components\Toggle::make('driver')
                            ->default(false),
                    ])->grow(false)
                ])->columnSpanFull(),

                Section::make('Subscription Details')
                    ->icon('heroicon-m-information-circle')
                    ->description('Please provide the subscription details')
                    ->visible(fn(callable $get) => $get('booking_type') === 'subscription')
                    ->collapsible()
                    ->columns([
                        'sm' => 1,
                        'xl' => 2,
                        '2xl' => 2,
                    ])
                    ->schema([
                        Forms\Components\Select::make('subscription_plan')
                            ->options([
                                'basic' => 'Basic',
                                'premium' => 'Premium',
                            ])
                            ->native(false)
                            ->required(),
                        Forms\Components\Select::make('billing_cycle')
                            ->options([
                                'weekly' => 'Weekly',
                                'monthly' => 'Monthly',
                            ])
                            ->native(false)
                            ->required(),
                        Forms\Components\DatePicker::make('renewal_date')
                            ->native(false)
                            ->required(),
                        Forms\Components\DatePicker::make('next_billing_date')
                            ->native(false)
                            ->required(),
                        // Forms\Components\DatePicker::make('last_notified'),
                        Forms\Components\Toggle::make('auto_renewal'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vehicle.title'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'info' => BookingStatus::New ->value,
                        'warning' => BookingStatus::Processing->value,
                        'success' => BookingStatus::Completed->value,
                        'danger' => BookingStatus::Cancelled->value,
                    ])
                    ->icons([
                        'heroicon-m-sparkles' => BookingStatus::New ->value,
                        'heroicon-m-arrow-path' => BookingStatus::Processing->value,
                        'heroicon-m-check-badge' => BookingStatus::Completed->value,
                        'heroicon-m-x-circle' => BookingStatus::Cancelled->value,
                    ])
                    ->label('Order Status'),
                Tables\Columns\TextColumn::make('latest_payment')
                    ->label('Lastest Payment')
                    ->getStateUsing(fn($record) => $record->payments->last()?->amount)
                    ->numeric()
                    ->money('QAR'),
                Tables\Columns\TextColumn::make('lastest_payment_status')
                    ->label('Status')
                    ->default('pending')
                    ->getStateUsing(fn($record) => $record->payments->last()?->status)
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'gray',
                        'success' => 'success',
                        'failed' => 'danger',
                    }),

                Tables\Columns\TextColumn::make('booking_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'rental' => 'info',
                        'subscription' => 'success',
                    })
                    ->icons([
                        'heroicon-m-bolt' => 'rental',
                        'heroicon-m-arrow-uturn-left' => 'subscription',
                    ]),
                Tables\Columns\TextColumn::make('protection')
                    ->label('Protection Plan'),
                Tables\Columns\TextColumn::make('pickupLocation.name')
                    ->label('Pickup Location'),
                Tables\Columns\TextColumn::make('pickup_date')
                    ->label('Pickup Date & Time'),
                Tables\Columns\TextColumn::make('returnLocation.name')
                    ->label('Return Location')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('return_date')
                    ->label('Return Date & Time')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime(),
                Tables\Columns\TextColumn::make('latest_transaction_id')
                    ->label('Transaction Id')
                    ->getStateUsing(fn($record) => $record->payments->last()?->transaction_id)
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Filters\Filter::make('Rental')
                    ->query(fn(Builder $query): Builder => $query->where('booking_type', 'rental')),

                Tables\Filters\Filter::make('Subscription')
                    ->query(fn(Builder $query): Builder => $query->where('booking_type', 'subscription')),
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
            PaymentsRelationManager::class,
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
