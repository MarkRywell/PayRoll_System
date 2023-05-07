<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Salary extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public function payroll() {
        return $this->belongsTo(PayRoll::class);
    }

    public function deduction() {
        return $this->hasOne(Deduction::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'payroll_id',
        'user_id',
        'gross_salary',
        'deduction',
        'net_salary',
    ];

    public static function createSalary($request)
    {
        $salary = Salary::create([
            'payroll_id' => $request['payroll_id'],
            'user_id' => $request['user_id'],
            'gross_salary' => $request['gross_salary'],
            'deduction' => $request['deduction'],
            'net_salary' => $request['net_salary']
        ]);

        return $salary;
    }

    
}
