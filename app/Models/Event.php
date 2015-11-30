<?php namespace App\Models;

/**
 * @property int       id
 * @property string    title
 * @property string    location temporary field until we get the location table right (#130)
 * @property string    slug
 * @property string    website
 * @property string    twitter
 * @property string    hashtag
 * @property int       disclosed_participants
 * @property bool      free
 * @property bool      closed
 * @property bool      published
 * @property int       status
 * @todo            https://bitbucket.org/konato/web/issues/130/integrate-with-google-maps-api-for-location-search
 *
 * @future-property Location  location
 * @property EventType type
 */
class Event extends Base {

    public static $rules = [
        'title'         => ['required', 'min:4', 'max:100'],
        'location'      => ['required', 'min:4', 'max:50'],
        'website'       => ['url'],
        'free'          => ['boolean'],
        'closed'        => ['boolean'],
        'hidden'        => ['boolean'],
        'event_type_id' => ['required']
    ];

    public static $relationsData = [
//        'location' => [self::BELONGS_TO, Location::class],
        'type' => [self::BELONGS_TO, EventType::class]
    ];
}
