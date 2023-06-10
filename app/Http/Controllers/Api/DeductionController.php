<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deduction;
use Illuminate\Http\Request;

class DeductionController extends Controller
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
    public static function calculateDeductions($gross_salary)
    {     
        $tax = 0;

        $sss = 0;

        if($gross_salary < 4250) {
            $sss = 180;
        }
        elseif($gross_salary >= 4250 && $gross_salary <= 4749.99) {
            $sss = 202.5;
        }
        elseif($gross_salary >= 4750 && $gross_salary <= 5249.99) {
            $sss = 202.5;
        }
        elseif($gross_salary >= 5250 && $gross_salary <= 5749.99) {
            $sss = 202.5;
        }
        elseif($gross_salary >= 6250 && $gross_salary <= 6249.99) {
            $sss = 202.5;
        }
        elseif($gross_salary >= 6750 && $gross_salary <= 6749.99) {
            $sss = 202.5;
        }
        elseif($gross_salary >= 7250 && $gross_salary <= 7249.99) {
            $sss = 202.5;
        }
        elseif($gross_salary >= 7750 && $gross_salary <= 7749.99) {
            $sss = 202.5;
        }
        elseif($gross_salary >= 8250 && $gross_salary <= 8249.99) {
            $sss = 202.5;
        }
        elseif($gross_salary >= 8750 && $gross_salary <= 8749.99) {
            $sss = 202.5;
        }
        elseif($gross_salary >= 9250 && $gross_salary <= 9249.99) {
            $sss = 202.5;
        }
        elseif($gross_salary >= 9750 && $gross_salary <= 9749.99) {
            $sss = 202.5;
        }

        if($gross_salary >= 5000) {
            $pagibig = $gross_salary * 0.03;
        }
        else {
            $pagibig = $gross_salary * 0.02;
        }
        
        $philhealth = $gross_salary * 0.045;

        $benefits = $sss + $pagibig + $philhealth;

        $taxable_income = $gross_salary - $benefits;
        
        if($taxable_income < 20833) {
            $tax = 0;
        }
        elseif($taxable_income >= 20833 && $taxable_income <= 33332) {
            $tax = ($taxable_income - 20833.33) * 0.2;
        }
        elseif ($taxable_income >= 33333 && $taxable_income <= 66666) {
            $tax = ($taxable_income - 33333) * 0.2;
        }
        elseif ($taxable_income >= 66667 && $taxable_income <= 166666) {
            $tax = ($taxable_income - 66667) * 0.2;
        }
        elseif ($taxable_income >= 166667 && $taxable_income <= 666666) {
            $tax = ($taxable_income - 166667) * 0.2;
        }
        else {
            $tax = ($taxable_income - 666667) * 0.2;
        }


        $total_deduction = $benefits + $tax;
        
        $deductions = [
           'total_deduction' => round($total_deduction, 2), 
           'sss' => round($sss, 2), 
           'pagibig' => round($pagibig, 2), 
           'philhealth' => round($philhealth, 2), 
           'tax' => round($tax, 2)
        ];

        return $deductions;
    }

    /**
     * Display the specified resource.
     */
    public function show(Deduction $deduction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deduction $deduction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deduction $deduction)
    {
        //
    }
}
