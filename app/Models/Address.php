<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Address extends Model
{
    use HasFactory, Notifiable;

    public function users() {
        return $this->hasMany(User::class);
    }

    protected $fillable = [
        'city',
        'zip_code',
        'state',
        'street',
        'country'
    ];

    public static function createAddress($request) {
        return Address::create([
            'street' => $request['street'],
            'city' => $request['city'],
            'state' => $request['state'],
            'zip_code' => $request['zip_code'],
            'country' => $request['country']
        ]);
    }

    public static function getAddress($id) {
        return Address::where('id', $id);
    }
}
