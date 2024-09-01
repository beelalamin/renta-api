<?php

namespace App\Http\Resources\V1\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\App;

class VehicleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($vehicle) {
            return [
                'id' => $vehicle->id,
                'title' => $vehicle->getTranslation('title', App::getLocale()),
                'price' => $vehicle->price,
                'brand' => $vehicle->getTranslation('title', App::getLocale()),
                'vehicleNumber' => $vehicle->vehicle_number,
                'model' => $vehicle->model,
                'thumbnail' => $vehicle->thumbnail->url ?? null,
                'transmission' => $vehicle->transmission,
                'fuelType' => $vehicle->fuel_type,
                'seatingCapacity' => $vehicle->seating_capacity,
                'mileage' => $vehicle->mileage,
                'isFeatured' => $vehicle->is_featured,
            ];
        })->toArray();
    }
}
