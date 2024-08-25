<?php

namespace App\Http\Controllers\api\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\Customer\StoreCustomerRequest;
use App\Http\Requests\Shop\Customer\UpdateCustomerRequest;
use App\Http\Requests\Shop\CustomerRequest;
use App\Models\shop\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $data = $request->validated();
        $customer = Customer::create($data);

        return $customer
            ? response()->json([
                'message' => 'Created Successfully!',
                'customer_id' => $customer->id,
            ], 201)
            : response()->json(['error' => 'Failed to create!'], 400);

    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, string $id)
    {
        $data = $request->validated();
        $customer = Customer::where('user_id', $id)->first();

        if (!$customer) {
            return response()->json(['error' => 'Customer not found!'], 404);
        }

        $updated = $customer->update($data);

        return $updated
            ? response()->json([
                'success' => 'Updated successfully!',
                'customer_id' => $customer->id,
            ], 200)
            : response()->json(['error' => 'Failed to update!'], 400);
    }
}
