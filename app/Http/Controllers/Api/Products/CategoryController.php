<?php

namespace App\Http\Controllers\api\products;

use App\Http\Controllers\Controller;
use App\Http\Resources\products\CategoryResource;
use App\Models\products\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }

}
