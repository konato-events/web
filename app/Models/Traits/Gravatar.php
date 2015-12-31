<?php namespace App\Models\Traits;

trait Gravatar {

    public static function generateGravatar(string $email, int $size = 80) {
        $rating = 'g';  //g | pg | r | x
        $set    = 'identicon'; //mm | identicon | monsterid | wavatar

        return 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($email))).'?'.http_build_query([
            's' => $size,
            'd' => $set,
            'r' => $rating
        ]);
    }

}
