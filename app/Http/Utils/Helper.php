<?php

namespace App\Http\Utils;

use App\Models\User;
use Nette\Utils\Json;

class Helper {
    public static function authDecode(User $user){
        return Json::decode($user->tokens[0]->name);
    }
}
