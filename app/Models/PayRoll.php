<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayRoll extends Model
{
    use HasApiTokens, SoftDeletes, HasFactory, Notifiable;

    protected $fillable = [
        'rate',
        'month',
        'working_days'
        'salary'
    ];
}
