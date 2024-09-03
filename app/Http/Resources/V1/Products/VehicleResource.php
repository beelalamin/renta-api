<?php

namespace App\Http\Resources\V1\Products;

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
            'brand' => $this->getTranslation('title', $locale),
            'transmission' => $this->transmission,
            'fuelType' => $this->fuel_type,
            'model' => $this->model,
            'seatingCapacity' => $this->seating_capacity,
            'mileage' => $this->mileage,
            'is_featured' => $this->is_featured,
            'is_published' => $this->is_featured,
            'thumbnail' => $this->thumbnail->url ?? null,
            'images' => optional($this->images)->map(function ($image) {
                return url($image->url);
            })->toArray(),
            'categories' => CategoryResource::collection($this->categories),
        ];
    }
}
