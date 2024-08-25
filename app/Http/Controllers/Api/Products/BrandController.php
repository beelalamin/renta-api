<?php

namespace App\Http\Controllers\api\products;

use App\Http\Controllers\Controller;
use App\Http\Resources\products\BrandResource;
use App\Models\products\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return BrandResource::collection($brands);
    }
}
