<?php namespace App\Models;

/**
 * @property int id
 * @property int event_id
 * @property int user_id
 * @property bool important
 */
class EventSpeaker extends Base {

    protected $table = 'event_speaker';

    public static $relationsData = [
        'sessions' => [self::BELONGS_TO_MANY, Session::class, 'table' => 'session_speaker']
    ];

}
