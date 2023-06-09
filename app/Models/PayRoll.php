<?php

namespace App\Models;

use App\Http\Controllers\Api\PayrollController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
class PayRoll extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function salary() {
        return $this->hasOne(Salary::class);
    }

    protected $fillable = [
        'month',
        'working_days',
        'total_hours_overtime',
        'user_id'
    ];

    public static function createPayRoll($request)
    {   
        $payroll = PayRoll::create([
            'month' => $request['month'],
            'working_days' => $request['working_days'],
            'total_hours_overtime' => $request['total_hours_overtime'],
            'user_id' => $request['user_id']
        ]);

        return $payroll;
    }

    public static function getPayRoll($user_id)
    {
        return PayRoll::where('user_id', $user_id)->get();
    }

    public static function getPayRollByMonth($month)
    {
        return PayRoll::where('month', $month)->get();
    }

    public static function getLatestPayRoll($user_id)
    {
        return Payroll::where('user_id', $user_id)->latest()->first();
    }
}
