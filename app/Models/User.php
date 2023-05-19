<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, SoftDeletes, HasFactory, Notifiable;

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function address() {
        return $this->belongsTo(Address::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'address_id',
        'name',
        'email',
        'password',
        'contact_number',
        'position',
        'rate',
        'status',
        'photo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function getUserbyEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public static function getRate($id)
    {
        return User::where('id', $id)->get('rate');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
}
