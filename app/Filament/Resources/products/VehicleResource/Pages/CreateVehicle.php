<?php

namespace App\Filament\Resources\Products\VehicleResource\Pages;

use App\Filament\Resources\Products\VehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVehicle extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = VehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Actions\LocaleSwitcher::make(),
        ];
    }
}
