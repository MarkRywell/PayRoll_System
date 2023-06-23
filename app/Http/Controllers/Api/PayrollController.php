<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PayRoll;
use App\Models\Salary;
use App\Http\Controllers\Api\DeductionController;
use App\Models\Deduction;
use App\Models\User;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $payrolls = Payroll::get();
        $users = User::withTrashed()->get();

        $payroll_list = [];

        foreach($users as $user) {
            foreach($payrolls as $payroll) {
                if($payroll->user_id == $user->id) {
                    $payroll_list[] = [
                        'payroll' => $payroll,
                        'user' => $user->name,
                        'rate' => $user->rate
                    ];
                }
            }
        }

        return $payroll_list;
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
            'month' => 'required|string',
            'working_days' => 'required|integer',
            'total_hours_overtime' => 'required|integer',
            'user_id' => 'required'
        ]);

        if($validator->fails()) {
            $responseData['message'] = $validator->errors()->first();
            return response()->json($responseData, 400);
        }

        if(!$request['rate']) {
            $request['rate'] = User::getRate($request['user_id'])[0]['rate'];
        }

        $overtime_salary = ($request['rate'] * 1.25) * $request['total_hours_overtime'];

        $cash_advance = $request['cash_advance'] ? $request['cash_advance'] : 0;

        $gross_salary = (($request['rate'] * 8)* $request['working_days']) + $overtime_salary;

        $deducted_gross_salary = (($request['rate'] * 8)* $request['working_days']) + $overtime_salary - $cash_advance;
        
        $payroll = PayRoll::createPayRoll($request);

        if(!$payroll) {
            return response()->json($responseData, 400);
        }

        $deduction = DeductionController::calculateDeductions($deducted_gross_salary);
        

        $net_salary = $deducted_gross_salary - $deduction['total_deduction'];
        $deduction['total_deduction'] = $deduction['total_deduction'] + $cash_advance;

        $salary = [
            'payroll_id' => $payroll->id,
            'user_id' => $payroll->user_id,
            'gross_salary' => $gross_salary,
            'deduction' => $deduction['total_deduction'],
            'net_salary' => $net_salary
        ];

        $salary = Salary::createSalary($salary);

        $deduction['salary_id'] = $salary->id;
        $deduction['cash_advance'] = $cash_advance;

        $deduction = Deduction::createDeduction($deduction);

        $responseData = [
            'status' => 'success',
            'message' => 'PayRoll Created Successfully!',
            'data' => [$payroll, $salary, $deduction]
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

    public function showLatest(int $user_id)
    {   
        $payroll = PayRoll::getLatestPayRoll($user_id);

        if(!$payroll) {
            return response()->json();
        }
        
        $salary = Salary::getSalaryLatest($payroll->id);

        $deduction = Deduction::getDeductionBySalaryId($salary->id);

        $data = [
            'payroll' => $payroll,
            'salary' => $salary,
            'deduction' => $deduction[0]
        ];
        return $data;
    }

    public function getOwnPayroll(int $user_id)
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
