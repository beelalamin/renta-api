<?php

namespace App\Filament\Resources\Products\BrandResource\Pages;

use App\Filament\Resources\Products\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBrand extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
            
        ];
    }
}
