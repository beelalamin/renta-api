<?php

namespace App\Filament\Resources\system\UserResource\Pages;

use App\Filament\Resources\system\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
