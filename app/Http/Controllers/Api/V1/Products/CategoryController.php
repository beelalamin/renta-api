<?php

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Products\CategoryResource;
use App\Models\Products\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return $categories ? CategoryResource::collection($categories)
            : response()
                ->json(['error' => 'Failed to fetch data!']);
    }

}
