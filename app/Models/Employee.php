<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'status',
        'photo'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];
}
