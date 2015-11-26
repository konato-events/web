<?php namespace App\Models;

/**
 * @property string title
 * @property string slug
 * @property string website
 * @property string twitter
 * @property string hashtag
 * @property int disclosed_participants
 * @property bool free
 * @property bool closed
 * @property bool published
 * @property int status
 *
 * @property Location location
 * @property EventType type
 */
class Event extends Base {

    public static $rules = [
        'name' => ['required', 'min:4']
    ];

    public static $relationsData = [
        'location' => [self::BELONGS_TO, Location::class],
        'type' => [self::BELONGS_TO, EventType::class]
    ];
}