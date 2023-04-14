<?php

namespace App\Models;

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

    protected $fillable = [
        'rate',
        'month',
        'working_days',
        'salary',
        'user_id'
    ];

    public static function createPayRoll($request)
    {   
        $payroll = PayRoll::create([
            'rate' => $request['rate'],
            'month' => $request['month'],
            'working_days' => $request['working_days'],
            'salary' => $request['salary'],
            'user_id' => $request['user_id']
        ]);

        return $payroll;
    }

    public static function getPayRoll($user_id)
    {
        $payroll = PayRoll::where('user_id', $user_id);

        return $payroll;
    }
}
