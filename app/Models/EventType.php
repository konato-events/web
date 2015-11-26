<?php namespace App\Models;

/**
 * @property int id
 * @property string name
 * @property Event[] events
 */
class EventType extends Base {

    public static $relationsData = [
        'events' => [self::HAS_MANY, Event::class]
    ];

}