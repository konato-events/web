<?php namespace App\Models;

use Carbon\Carbon;

/**
 * @property int        id
 * @property string     title
 * @property string     location   Temporary field until we get the location table right (#130)
 * @property string     slug
 * @property string     website
 * @property string     tickets_url
 * @property string     facebook
 * @property string     facebook_event
 * @property string     twitter
 * @property string     hashtag
 * @property int        disclosed_participants
 * @property bool       free
 * @property bool       closed
 * @property bool       published
 * @property Carbon     begin
 * @property Carbon     end
 * @property int        status
 * @property string     publicImg  Temporary field until we get upload working
 * @todo            https://bitbucket.org/konato/web/issues/130/integrate-with-google-maps-api-for-location-search
 *
 * @future-property Location  location
 * @property EventType  type
 * @property Event[]    issues
 * @property User[]     speakers
 * @property Material[] materials
 */
class Event extends Base {

    protected $dates = ['created_at', 'updated_at', 'begin', 'end'];

    protected $dateFormat = 'Y-m-d H:i:sO';

    public static $rules = [
        'title'         => ['required', 'min:4', 'max:100'],
        'location'      => ['required', 'min:4', 'max:50'],
        'website'       => ['url'],
        'tickets_url'   => ['url'],
        'free'          => ['boolean'],
        'closed'        => ['boolean'],
        'hidden'        => ['boolean'],
        'event_type_id' => ['required']
    ];

    public static $relationsData = [
        'type'      => [self::BELONGS_TO, EventType::class],
        'issues'    => [self::HAS_MANY_THROUGH, self::class, 'through' => EventIssue::class, 'firstKey' => 'id'],
        'speakers'  => [self::BELONGS_TO_MANY, User::class, 'table' => 'event_speaker'],
        'materials' => [self::HAS_MANY, Material::class],
        //        'location' => [self::BELONGS_TO, Location::class],
    ];

    /**
     * Temporary attr until we get upload working
     * @todo https://bitbucket.org/konato/web/issues/129/implement-real-file-upload
     */
    public function getPublicImgAttribute() {
        $img = User::generateGravatar($this->title, 128);
        return $img;
    }
}
