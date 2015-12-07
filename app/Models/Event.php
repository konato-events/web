<?php namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property int        id
 * @property string     title
 * @property string     location   Temporary field until we get the location table right (#130)
 * @property string     address
 * @property string     postal_code
 * @property string     description
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
 * @property EventType             type
 * @property Collection|Event[]    issues
 * @property Collection            staff
 * @property Collection|User[]     speakers
 * @property Collection|Material[] materials
 * @property Collection|Theme[]    themes
 * @property Collection|Session[]  sessions
 * @property Session[]  sessionsByDay
 *
 * @method BelongsTo        type
 * @method HasManyThrough   issues
 * @method BelongsToMany    staff
 * @method BelongsTo        event_staff
 * @method BelongsToMany    speakers
 * @method HasMany          materials
 */
class Event extends Base {

    protected $dates = ['created_at', 'updated_at', 'begin', 'end'];

    protected $dateFormat = 'Y-m-d H:i:sO';

    public static $rules = [
        'title'          => ['required', 'min:4', 'max:100', 'unique:events'],
        'tagline'        => ['min:5', 'max:50'],
        'description'    => ['min:20'],
        'location'       => ['required', 'min:4', 'max:50'],
        'address'        => ['min:10'],
        'postal_code'    => ['min:3'],
        'begin'          => ['date'],
        'end'            => ['date'],
        'website'        => ['url'],
        'twitter'        => ['min:2'],
        'hashtag'        => ['min:4'],
        'facebook'       => ['url'],
        'facebook_event' => ['url'],
        'tickets_url'    => ['url'],
        'free'           => ['boolean'],
        'closed'         => ['boolean'],
        'hidden'         => ['boolean'],
        'event_type_id'  => ['required'],

        'speakers' => '',
        'themes_str' => '',
        'schedule_file' => ['file'],
    ];

    public static $relationsData = [
        'type'        => [self::BELONGS_TO, EventType::class],
        'issues'      => [self::HAS_MANY_THROUGH, self::class, 'through' => EventIssue::class, 'firstKey' => 'id'],
        'speakers'    => [self::BELONGS_TO_MANY, User::class, 'table' => 'event_speaker'],
        'staff'       => [self::BELONGS_TO_MANY, User::class, 'table' => 'event_staff'],
        'themes'      => [self::BELONGS_TO_MANY, Theme::class, 'table' => 'event_theme'],
        'event_staff' => [self::HAS_MANY, EventStaff::class],
        'materials'   => [self::HAS_MANY, Material::class],
        'sessions'    => [self::HAS_MANY, Session::class],
        //        'location' => [self::BELONGS_TO, Location::class],
    ];

    protected $sessionsByDay = [];

    /**
     * Temporary attr until we get upload working
     * @todo https://bitbucket.org/konato/web/issues/129/implement-real-file-upload
     */
    public function getPublicImgAttribute() {
        $img = User::generateGravatar($this->title, 128);
        return $img;
    }

    public function setEndAttribute(string $datetime = null) {
        $this->attributes['end'] = $datetime?: null;
    }

    protected function clearFacebookURL(string $url) {
        $url = strtok($url, '?');
        $url = strtr($url, ['facebook.com' => 'fb.com']);
        $url = rtrim($url, '/');
        return $url;
    }

    public function setFacebookAttribute(string $url = null) {
        $this->attributes['facebook'] = $url? $this->clearFacebookURL($url) : null;
    }

    public function setFacebookEventAttribute(string $url = null) {
        $this->attributes['facebook_event'] = $url? $this->clearFacebookURL($url) : null;
    }

    public function isStaff(User $user = null) {
        if (!Auth::check()) {
            return false;
        } else {
            $user = $user?: Auth::user();
            return (bool)$this->event_staff()->where('user_id', $user->id)->count();
        }
    }

    public function getSessionsByDayAttribute() {
        if (!$this->sessionsByDay) {
            foreach ($this->sessions as $session) {
                $day = $session->begin->format('Y-m-d');
                if (!array_key_exists($day, $this->sessionsByDay)) {
                    $this->sessionsByDay[$day] = [];
                }
                $this->sessionsByDay[$day][] = $session;
            }
        }

        return $this->sessionsByDay;
    }
}
