<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deduction;
use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $salary = Salary::get();
       $deduction = Deduction::get();

       return response()->json(['salary' => $salary, 'deduction' => $deduction]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $salary = Salary::getSalaryByPayrollId($id);
        $salary = $salary[0];
        $deduction = Deduction::getDeductionBySalaryId($salary['id']);
        $deduction = $deduction[0];

        return response()->json(['salary' => $salary, 'deductions' => $deduction]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salary $salary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salary $salary)
    {
        //
    }
}
