<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Brand extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $fillable = [
        'title',
    ];

    protected $translatable = [
        'title',
    ];

    protected static function newFactory()
    {
        return \Database\Factories\products\BrandFactory::new();
    }
}
