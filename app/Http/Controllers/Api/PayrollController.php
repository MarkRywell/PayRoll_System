<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PayRoll;

class PayrollController extends Controller
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
        $responseData = [
            'status' => 'fail',
            'message' => 'PayRoll Unsuccessful',
            'data' => null
        ];

        $validator = Validator::make($request->all(), [
            'rate' => 'required|numeric',
            'month' => 'required|string',
            'working_days' => 'required|integer',
            'user_id' => 'required'
        ]);

        if($validator->fails()) {
            $responseData['message'] = $validator->errors()->first();
            return response()->json($responseData, 400);
        }

        $request['salary'] = $request['rate'] * $request['working_days'];

        // var_dump($request);

        $payroll = PayRoll::createPayRoll($request);

        if($payroll) {
            $responseData = [
                'status' => 'success',
                'message' => 'PayRoll Created Successfully!',
                'data' => $payroll
            ];

            return response()->json($responseData, 201);
        }
        return response()->json($responseData, 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $user_id)
    {
        return PayRoll::getPayRoll($user_id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PayRoll $payRoll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PayRoll $payRoll)
    {
        //
    }
}
