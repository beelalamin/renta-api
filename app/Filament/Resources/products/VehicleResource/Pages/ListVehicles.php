<?php

namespace App\Filament\Resources\products\VehicleResource\Pages;

use App\Filament\Resources\products\VehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVehicles extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = VehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }

   
}
