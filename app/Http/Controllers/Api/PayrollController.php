<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PayRoll;
use App\Models\Salary;
use App\Http\Controllers\Api\DeductionController;
use App\Models\Deduction;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PayRoll::get();
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
            'total_hours_overtime' => 'required|integer',
            'user_id' => 'required'
        ]);

        if($validator->fails()) {
            $responseData['message'] = $validator->errors()->first();
            return response()->json($responseData, 400);
        }

        $overtime_salary = ($request['rate'] * 1.25) * $request['total_hours_overtime'];

        $gross_salary = ($request['rate'] * $request['working_days']) + $overtime_salary;
        
        $payroll = PayRoll::createPayRoll($request);

        if(!$payroll) {
            return response()->json($responseData, 400);
        }

        $deduction = DeductionController::calculateDeductions($gross_salary);

        $net_salary = $gross_salary - $deduction['total_deduction'];

        $salary = [
            'payroll_id' => $payroll->id,
            'user_id' => $payroll->user_id,
            'gross_salary' => $gross_salary,
            'deduction' => $deduction['total_deduction'],
            'net_salary' => $net_salary
        ];

        $salary = Salary::createSalary($salary);

        $deduction['salary_id'] = $salary->id;

        $deduction = Deduction::createDeduction($deduction);

        $responseData = [
            'status' => 'success',
            'message' => 'PayRoll Created Successfully!',
            'data' => [$payroll, $salary]
        ];

        return response()->json($responseData, 201);
       
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
