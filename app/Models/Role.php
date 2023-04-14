<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Role extends Model
{
    use HasApiTokens, HasFactory;

    public function user() {
        return $this->hasMany(User::class);
    }

    protected $fillable = [
        'name'
    ];

    public $timestamps = false; 
}
