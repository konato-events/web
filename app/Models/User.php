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
 * @property string gender
 * @property string avatar
 * @property string picture
 * @property SocialLink[] links
 */
class User extends Base implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    protected $hidden = [ 'password', /*'remember_token'*/ ];

    public static $rules = [
        'name'                  => ['required', 'min:4'],
        'email'                 => ['required', 'email', /*'unique:users'*/],
        'password'              => ['min:6', 'confirmed'], //TODO: should be required on signup
        'password_confirmation' => ['min:6'], //TODO: should be required on signup
        'username'              => ['required', 'between:4,30', /*'unique:users'*/],
        'tagline'               => ['between:10,50'],
        'bio'                   => ['between:10,200'],
        //TODO: validate birthday range correctly
        'birthday'              => ['date_format:Y-m-d', /*'after:6 years', 'before:1875-02-21'*/], //https://en.wikipedia.org/wiki/Oldest_people#Oldest_people_ever
        'gender'                => ['in:M,F'],
    ];

    public static $relationsData = [
        'links' => [self::HAS_MANY, SocialLink::class]
    ];

}
