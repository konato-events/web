<?php namespace App\Http\Requests;

use App\Models\User;

/**
 * @property string email
 * @property string username
 * @property string provider
 * @property string provider_id
 */
class SignUpFinish extends Request {

    function rules() {
        //removes "required" if it's there and adds "required if provider == twitter"
        $email_rules   = User::$rules['email'];
        $email_rules[] = 'required_if:provider,twitter';
        $required_key  = array_search('required', $email_rules);
        if ($required_key !== false) {
            unset($email_rules[$required_key]);
        }

        return [
            'email'    => $email_rules,
            'username' => User::$rules['username'],
            'provider' => 'required'
        ];
    }
}
