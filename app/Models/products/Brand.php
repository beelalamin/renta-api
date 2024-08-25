<?php

namespace App\Models\products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Brand extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $fillable = [
        'brand_name',
        'model_name',
    ];

    protected $translatable = [
        'brand_name',
        'model_name',
    ];

    protected static function newFactory()
    {
        return \Database\Factories\products\BrandFactory::new();
    }
}
