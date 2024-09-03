<?php

namespace App\Models\Products;

use App\Models\Shop\Booking;
use App\Models\User;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Spatie\Translatable\HasTranslations;

class Vehicle extends Model
{
    use HasFactory, HasTranslations;

    protected $translatable = [
        'title',
        'description',
    ];
    protected $fillable = [
        'title',
        'description',
        'price',
        'brand_id',
        'thumbnail_id',
        'vehicle_number',
        'transmission',
        'fuel_type',
        'model',
        'seating_capicity',
        'mileage',
        'is_featured',
        'is_published',
    ];

    protected $casts = [
        'attributes' => 'array',
        'rental' => 'boolean',
        'subscription' => 'boolean',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];


    // protected function getTableQuery()
    // {
    //     return parent::getTableQuery()->with(['thumbnail']);
    // }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_vehicle', 'vehicle_id', 'category_id');
    }

    public function thumbnail()
    {
        return $this->belongsTo(Media::class, 'thumbnail_id', 'id');
    }

    public function images()
    {
        return $this
            ->belongsToMany(Media::class, 'vehicle_media', 'vehicle_id', 'media_id');
    }

    public function booking(): HasOne
    {
        return $this->hasOne(Booking::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::id() ?? 1;
            $model->updated_by = Auth::id() ?? 1;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id() ?? 1;
        });
    }

    // Vehicle Filter Scopes
    public function scopeBrand(Builder $query, $brandIds)
    {
        return $query->whereIn('brand_id', explode(',', $brandIds));
    }

    public function scopeCategories(Builder $query, $categoryIds)
    {
        return $query->whereHas('categories', function ($query) use ($categoryIds) {
            $query->whereIn('categories.id', explode(',', $categoryIds));
        });
    }

    public function scopePriceRange(Builder $query, $value)
    {
        if (empty($value)) {
            return $query;
        }

        $values = is_array($value) ? $value : explode(',', $value);
        $min = isset($values[0]) && is_numeric($values[0]) ? (float) $values[0] : null;
        $max = isset($values[1]) && is_numeric($values[1]) ? (float) $values[1] : null;

        if ($min !== null && $max !== null) {
            return $query->whereBetween('price', [$min, $max]);
        } elseif ($min !== null) {
            return $query->where('price', '>=', $min);
        } elseif ($max !== null) {
            return $query->where('price', '<=', $max);
        }

        return $query;
    }

    // Vehicle Factory Function
    protected static function newFactory()
    {
        return \Database\Factories\products\VehicleFactory::new();
    }

}
