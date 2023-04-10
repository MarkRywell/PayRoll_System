<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayRoll extends Model
{
    use HasApiTokens, SoftDeletes, HasFactory, Notifiable;

    public function user() {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'rate',
        'month',
        'working_days'
        'salary'
    ];
}
