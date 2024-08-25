<?php

namespace App\Filament\Resources\Shop\BookingResource\Pages;

use App\Filament\Resources\Shop\BookingResource;
use App\Models\shop\Payment;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;
}
