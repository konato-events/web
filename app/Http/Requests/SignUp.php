<?php namespace App\Http\Requests;

use App\Models\User;

class SignUpReq extends Request {
    function rules() {
        return User::changeRules(User::SC_SIGNUP);
    }
}
