<?php

namespace App\Http\Resources\products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class BrandResource extends JsonResource
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
            'brand_name' => $this->getTranslation('brand_name', $locale),
            'model_name' => $this->getTranslation('model_name', $locale),
        ];
    }
}
