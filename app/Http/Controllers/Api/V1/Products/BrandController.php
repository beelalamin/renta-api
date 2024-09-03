<?php

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Products\BrandResource;
use App\Models\Products\Brand;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return $brands ? BrandResource::collection($brands)
            : response()
                ->json(['error' => 'Failed to fetch data!']);
        ;
    }
}
