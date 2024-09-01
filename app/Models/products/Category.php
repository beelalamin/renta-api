<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations;
    protected $fillable = [
        'title',
        'parant_id'
    ];

    protected $translatable = [
        'title',
    ];

    protected static function newFactory()
    {
        return \Database\Factories\products\CategoryFactory::new();
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class);
    }
}
