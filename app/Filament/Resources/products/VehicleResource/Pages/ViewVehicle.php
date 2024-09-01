<?php

namespace App\Filament\Resources\Products\VehicleResource\Pages;

use App\Filament\Resources\Products\VehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewVehicle extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;
    protected static string $resource = VehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\LocaleSwitcher::make(),

        ];
    }
}
