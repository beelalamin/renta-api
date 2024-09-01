<?php

namespace App\Http\Controllers\Api\V1\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Products\BrandResource;
use App\Http\Resources\V1\Products\CategoryResource;
use App\Models\Products\Brand;
use App\Models\Products\Category;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function index()
    {

        $categories = Category::all();
        $brands = Brand::all();

        if ($categories->isNotEmpty() || $brands->isNotEmpty()) {
            return response()->json([
                'categories' => CategoryResource::collection($categories),
                'brands' => BrandResource::collection($brands)
            ], 200);
        }

        return response()->json(['error' => 'No data found!'], 404);

    }
}
