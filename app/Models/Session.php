<?php namespace App\Models;

use Carbon\Carbon;

/**
 * @property int    id
 * @property string title
 * @property string description
 * @property Carbon begin
 * @property Carbon end
 * @property Event  event
 *
 */
class Session extends Base {

    public static $relationsData = [
        'event'    => [self::BELONGS_TO, Event::class],
        'themes'   => [self::BELONGS_TO_MANY, Theme::class, 'table' => 'session_theme'],
        'speakers' => [self::BELONGS_TO_MANY, User::class, 'table' => 'session_speaker'],
    ];

}