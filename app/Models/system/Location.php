<?php

namespace App\Models\system;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Location extends Model
{
     use HasFactory;

    protected $fillable = [
        'name',
        'latitude',
        'langitude',
    ];
}
