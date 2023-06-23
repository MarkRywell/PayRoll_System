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
    public static function store($addressData, Request $request = null)
    {   
        if(!filled($request)) {
            $request = $addressData;
        }

        $validator = Validator::make($request, [
            'street' => 'required|string',
            'city' => 'required|string',
            'state' => 'string',
            'zip_code' => 'required|integer',
            'country' => 'required|string'
        ]);

        if($validator->fails()) {
            $response = $validator->errors()->first();
            return $response;
        }

        $data = $request;

        $address = Address::createAddress($data);

        if(!$address) {
            return response()->json("Address Creation Unsuccessful", 500);
        }

        return $address;
    } 

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return response()->json(['address' => Address::getAddress($id)]);
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
