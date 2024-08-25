<?php

namespace App\Http\Resources\products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locale = App::getLocale();

        return [
            'id' => $this->id,
            'title' => $this->getTranslation('title', $locale),
            'description' => $this->getTranslation('description', $locale),
            'price' => $this->price,
            'vehicle_number' => $this->vehicle_number,
            'transmission' => $this->transmission,
            'status' => $this->status,
            'booking_type' => $this->booking_type,
            'brand' => [
                'id' => $this->brand->id,
                'brand_name' => $this->brand->getTranslation('brand_name', $locale),
                'model_name' => $this->brand->getTranslation('model_name', $locale),
            ],
            'thumbnail' => $this->thumbnail->url ?? null,
            'images' => optional($this->images)->map(function ($image) {
                return url($image->url);
            })->toArray(),
            'categories' => CategoryResource::collection($this->categories),
            'is_featured' => $this->is_featured,
            'is_published' => $this->is_featured,
        ];
    }
}
