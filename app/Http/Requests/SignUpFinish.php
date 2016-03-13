<?php namespace App\Http\Requests;

/**
 * @property string username
 * @property string provider
 * @property string provider_id
 */
class SignUpFinish extends Request {
    function rules() {
        return [
            'username' => User::$rules['username'],
            'provider' => 'required'
        ];
    }
}
