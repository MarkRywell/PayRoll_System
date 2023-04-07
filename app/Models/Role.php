<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
