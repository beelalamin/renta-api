<?php

namespace App\Filament\Resources\products\BrandResource\Pages;

use App\Filament\Resources\products\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBrands extends ListRecords
{
    use ListRecords\Concerns\Translatable;
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),

        ];
    }
}
