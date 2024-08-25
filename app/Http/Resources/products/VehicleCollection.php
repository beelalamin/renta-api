<?php

namespace App\Http\Resources\products;

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
                'vehicle_number' => $vehicle->vehicle_number,
                'thumbnail' => $vehicle->thumbnail->url ?? null,
                'transmission' => $vehicle->transmission,
                'brand' => [
                    'id' => $vehicle->brand->id,
                    'brand_name' => $vehicle->brand->getTranslation('brand_name', App::getLocale()),
                ],
                'status' => $vehicle->status,
            ];
        })->toArray();
    }
}
