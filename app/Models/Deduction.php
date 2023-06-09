<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Deduction extends Model
{
    use HasFactory, Notifiable;

    public function salary() {
        return $this->belongsTo(Salary::class);
    }

    protected $fillable = [
        'salary_id',
        'cash_advance',
        'sss',
        'pagibig',
        'philhealth',
        'tax',
        'total_deduction',
    ];

    public static function createDeduction($request)
    {
        return Deduction::create([
            'salary_id' => $request['salary_id'],
            'cash_advance' => $request['cash_advance'],
            'sss' => $request['sss'],
            'pagibig' => $request['pagibig'],
            'philhealth' => $request['philhealth'],
            'tax' => $request['tax'],
            'total_deduction' => $request['total_deduction'],
        ]);
    }

    public static function getDeductionBySalaryId($salary_id)
    {
        return Deduction::where('salary_id', $salary_id)->get();
    }
    


}
