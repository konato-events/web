<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use LaravelArdent\Ardent\Ardent;

/**
 * @property string name
 * @property string email
 * @property string password
 * @property string password_confirmation
 * @property string username
 * @property string tagline
 * @property string bio
 * @property string birthday
 */
class User extends Ardent implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    protected $hidden = [ 'password', /*'remember_token'*/ ];

    public static $rules = [
        'name'                  => ['required', 'min:4', 'alpha_dash'],
        'email'                 => ['required', 'email', /*'unique:users'*/],
        'password'              => ['required', 'min:6', 'confirmed'],
        'password_confirmation' => ['required', 'min:6'],
        'username'              => ['required', 'between:4,30', /*'unique:users'*/],
        'tagline'               => ['between:10,50'],
        'bio'                   => ['between:10,200'],
        'birthday'              => ['date_format:U', 'after:6 years', 'before:1875-02-21'] //https://en.wikipedia.org/wiki/Oldest_people#Oldest_people_ever
    ];

}
