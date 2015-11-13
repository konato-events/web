<?php namespace App\Models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use LaravelArdent\Ardent\Ardent;

/**
 * @property string name
 * @property string email
 * @property string password
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

    public $autoHashPasswordAttributes = true;

//    public $autoHydrateEntityFromInput = true;

    const PARTICIPANT = 'participant';
    const SPEAKER     = 'speaker';
    const INVOLVED    = 'involved';
    const STAFF       = 'staff';

    public static $rules = [
        'name'                  => ['required', 'min:4'],
        'email'                 => ['required', 'email', /*'unique:users'*/],
        //TODO: password should be required and confirmed on signup
        'password'              => ['min:6'],
        'username'              => ['required', 'between:4,30', /*'unique:users'*/],
        'tagline'               => ['between:10,50'],
        'bio'                   => ['between:10,200'],
        //TODO: validate birthday range correctly
        'birthday'              => ['date_format:Y-m-d', /*'after:6 years', 'before:1875-02-21'*/], //https://en.wikipedia.org/wiki/Oldest_people#Oldest_people_ever
        'gender'                => ['in:M,F'],
    ];

    public static $relationsData = [
        'links'    => [self::HAS_MANY, SocialLink::class],
        'location' => [self::BELONGS_TO, Location::class]
    ];

    public function beforeSave() {
//        unset($this->password_confirmation);
        $this->avatar  = $this->avatar  ?? self::generateGravatar($this->email, 100);
        $this->picture = $this->picture ?? self::generateGravatar($this->email, 1920);
    }

    protected static function generateGravatar(string $email, int $size = 80) {
        $rating = 'g';  //g | pg | r | x
        $set    = 'identicon'; //mm | identicon | monsterid | wavatar

        return 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($email))).'?'.http_build_query([
            's' => $size,
            'd' => $set,
            'r' => $rating
        ]);
    }

}
