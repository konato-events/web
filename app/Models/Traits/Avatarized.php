<?php namespace App\Models\Traits;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Enables a class to use Gravatars.
 * Expects the class that uses this trait to have "id", "avatar" and "picture" attributes.
 * By default, uses the "email" attribute in the gravatar generation; if another field should be used instead,
 * add a static attribute called "avatarGenerationField"
 *
 * @method MessageBag errors()
 * @property array $attributes
 * @property integer $id
 * @property string $email
 * @property string $avatar
 * @property string $picture
 */
trait Avatarized {

    public static function generateGravatar(string $email, int $size = 80) {
        $rating = 'g';  //g | pg | r | x
        $set    = 'identicon'; //mm | identicon | monsterid | wavatar

        return 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($email))).'?'.http_build_query([
            's' => $size,
            'd' => $set,
            'r' => $rating
        ]);
    }

    public function setPictureAttribute($file) {
        if (is_string($file)) {
            $path = $file; //TODO: should we copy the picture to our storage instead?
        } elseif ($file instanceof UploadedFile) {
            //no $file->guessExtension() as this would create dups if the user uploads a pic with a different extension
            $rel_path = 'users/picture-'.$this->id;
            $stored   = \Storage::put($rel_path, file_get_contents($file->getRealPath()));
            if (!$stored) {
                $this->errors()->add('picture', _('Sorry, we were unable to save your picture. Can you try again later?'));
            }
            $path = \Config::get('filesystems.root_url').$rel_path;
        }

        if (isset($path)) {
            //FIXME: resize the picture to create a smaller avatar (what size?)
            $this->attributes['picture'] = $this->attributes['avatar'] = $path;
        }
    }

    protected function beforeSave() {
        $field = isset(static::$avatarGenerationField)? $this->{static::$avatarGenerationField} : $this->email;
        $this->avatar  = $this->avatar  ?? self::generateGravatar($field, 128);
        $this->picture = $this->picture ?? self::generateGravatar($field, 1920);
    }

}
