<?php

namespace App\Http\Resources\V1\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class CategoryResource extends JsonResource
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
            'parent_id' => $this->parent_id,
            'title' => $this->getTranslation('title', $locale),
        ];
    }
}
