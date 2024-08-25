<?php

namespace App\Filament\Resources\products\BrandResource\Pages;

use App\Filament\Resources\products\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBrand extends ViewRecord
{
    use ViewRecord\Concerns\Translatable;

    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\LocaleSwitcher::make(),

        ];
    }
}
