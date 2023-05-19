<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'street' => 'required|string',
            'city' => 'required|string',
            'state' => 'string',
            'zip_code' => 'required|integer'
        ]);

        if($validator->fails()) {
            $response = $validator->errors()->first();
            return response()->json($response, 400);
        }

        $data = $request->all();

        $address = Address::createAddress($data);

        if(!$address) {
            return response()->json("Address Creation Unsuccessful", 500);
        }

        return response()->json(['message' => "Success", 'address' => $address], 201);
    } 

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        //
    }
}
