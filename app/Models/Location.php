<?php namespace App\Models;

/**
 * @property string name
 * @property int[]  coordinates
 */
class Location extends Base {

    public static $relationsData = [
        'parent'   => [self::BELONGS_TO, self::class],
        'children' => [self::HAS_MANY, self::class],
    ];

}
