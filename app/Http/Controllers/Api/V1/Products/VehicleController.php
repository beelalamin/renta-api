<?php

namespace App\Http\Controllers\Api\V1\Products;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Products\VehicleCollection;
use App\Http\Resources\V1\Products\VehicleResource;
use App\Models\Products\Vehicle;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = QueryBuilder::for(Vehicle::class)
            ->allowedFilters([
                AllowedFilter::scope('brand'),
                AllowedFilter::scope('categories'),
                AllowedFilter::scope('price_range'),
                AllowedFilter::exact('transmission'),
            ])
            ->allowedSorts('price')
            ->get();

        return $vehicles ? new VehicleCollection($vehicles)
            : response()
                ->json(['error' => 'Failed to fetch data!']);


        // // Initialize the query
        // $query = Vehicle::query();

        // // Apply filters after validation
        // if ($request->has('brand')) {
        //     $query->whereIn('brand_id', $request->input('brand'));
        // }

        // if ($request->has('categories')) {
        //     $query->whereHas('categories', function ($query) use ($request) {
        //         $query->whereIn('categories.id', $request->input('categories'));
        //     });
        // }

        // if ($request->has('transmission')) {
        //     $query->where('transmission', $request->input('transmission'));
        // }

        // if ($request->has('price_range')) {
        //     [$min, $max] = explode(',', $request->input('price_range'));
        //     $query->whereBetween('price', [(float) $min, (float) $max]);
        // }

        // return new VehicleCollection($query);

    }

    public function show(string $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        return $vehicle ? new VehicleResource($vehicle)
            : response()
                ->json(['error' => 'Failed to fetch data!']);
    }
}
