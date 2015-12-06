<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

//tricking gettext to find our four participation types
_('participant'); _('speaker'); _('involved'); _('staff');

/**
 * @property int          id
 * @property string       name
 * @property string       email
 * @property string       password
 * @property string       username
 * @property string       tagline
 * @property string       bio
 * @property string       birthday
 * @property string       gender
 * @property string       avatar
 * @property string       picture
 *
 * @property int[]        stats
 * @property array        events
 * @property array        most_visited
 *
 * @property Collection|SocialLink[] links
 * @property Location                location
 * @method BelongsTo                 location
 * @property Collection|User[]       follows
 * @method BelongsToMany             follows
 * @property Collection|User[]       followed_by
 * @method BelongsToMany             followed_by
 * @property Collection|Event[]      participated
 * @method BelongsToMany             participated
 * @property Collection|Event[]      organized
 * @method BelongsToMany             organized
 * @property Collection|Event[]      spoke
 * @method BelongsToMany             spoke
 * @property Collection|Event[]      following_events
 * @method BelongsToMany             following_events
 * @property Collection|Theme[]      following_themes
 * @method BelongsToMany             following_themes
 * @property Collection|EventSpeaker[] spoke_pivot
 * @method HasMany spoke_pivot
 * @property Collection|Session[]      sessions
 * @property Collection|Theme[]        all_themes
 */
class User extends Base implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    protected $hidden = ['password', /*'remember_token'*/];

    public $autoHashPasswordAttributes = true;

    protected $most_visited = [];
    protected $events = [];
    protected $sessions = [];
    protected $all_themes = [];

//    public $autoHydrateEntityFromInput = true;

    const PARTICIPANT = 'participant';
    const SPEAKER = 'speaker';
    const INVOLVED = 'involved'; //todo: include a "voluntary" or "lesser staff" role
    const STAFF = 'staff';

    const PARTICIPATION_RELATIONS = [
        'organized'    => self::STAFF,
        'spoke'        => self::SPEAKER,
        'participated' => self::PARTICIPANT
    ];

    public static $rules = [
        'name'     => ['required', 'min:4'],
        'email'    => ['required', 'email', 'unique:users'],
        //TODO: password should be required and confirmed on signup
        'password' => ['min:6'],
        'username' => ['required', 'between:4,30', 'unique:users'],
        'tagline'  => ['max:50'],
        'bio'      => ['max:200'],
        //TODO: validate birthday range correctly
        'birthday' => ['date_format:Y-m-d', /*'after:6 years', 'before:1875-02-21'*/],
        //https://en.wikipedia.org/wiki/Oldest_people#Oldest_people_ever
        'gender'   => ['in:M,F'],
    ];

    /** @see Ardent::handleRelationalArray() */
    public static $relationsData = [
        'location'         => [self::BELONGS_TO, Location::class],
        'follows'          => [
            self::BELONGS_TO_MANY,
            self::class,
            'table'      => 'following_user',
            'foreignKey' => 'follower_id'
        ],
        'followed_by'      => [
            self::BELONGS_TO_MANY,
            self::class,
            'table'    => 'following_user',
            'otherKey' => 'follower_id'
        ],
        'organized'        => [self::BELONGS_TO_MANY, Event::class, 'table' => 'event_staff'],
        'spoke'            => [self::BELONGS_TO_MANY, Event::class, 'table' => 'event_speaker'],
        'spoke_pivot'      => [self::HAS_MANY, EventSpeaker::class],
        'participated'     => [self::BELONGS_TO_MANY, Event::class, 'table' => 'participating_event'],
        'following_events' => [self::BELONGS_TO_MANY, Event::class, 'table' => 'following_event'],
        'following_themes' => [self::BELONGS_TO_MANY, Theme::class, 'table' => 'following_theme'],
        //'links'          => [self::HAS_MANY, SocialLink::class], //defined by method as we need ordering here
    ];

    public function links() {
        return $this->hasMany(SocialLink::class)->join('social_networks AS n', 'n.id', '=', 'social_network_id')
                    ->orderBy('n.position');
    }

    public function beforeSave() {
//        unset($this->password_confirmation);
        $this->avatar  = $this->avatar  ?? self::generateGravatar($this->email, 100);
        $this->picture = $this->picture ?? self::generateGravatar($this->email, 1920);
    }

    public static function generateGravatar(string $email, int $size = 80) {
        $rating = 'g';  //g | pg | r | x
        $set    = 'identicon'; //mm | identicon | monsterid | wavatar

        return 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($email))).'?'.http_build_query([
            's' => $size,
            'd' => $set,
            'r' => $rating
        ]);
    }

    //TODO: cache
    public function getStatsAttribute() {
        $stats = [];
        foreach (static::PARTICIPATION_RELATIONS as $relation => $name) {
            $stats[$name] = $this->$relation()->count();
        }

        return $stats;
    }

    /**
     * @todo cache
     * @return array Events indexed by ID, with 'event' (Event) and 'participation' (string) keys
     */
    public function getEventsAttribute() {
        if (!$this->events) {
            foreach (static::PARTICIPATION_RELATIONS as $relation => $name) {
                foreach ($this->$relation->all() as $event) {
                    $this->events[$event->id] = [
                        'event'         => $event,
                        'participation' => $name
                    ];
                }
            }
            ksort($this->events);
        }
        return Collection::make($this->events);
    }

    //TODO: cache
    public function getMostVisitedAttribute() {
        if (!$this->most_visited) {
            foreach ($this->events as $event) {
                if (!isset($this->most_visited[$event['event']->location])) {
                    $this->most_visited[$event['event']->location] = 1;
                } else {
                    ++$this->most_visited[$event['event']->location];
                }
            }
            asort($this->most_visited);
        }
        return $this->most_visited;
    }

    public function getSessionsAttribute() {
        if (!$this->sessions) {
            foreach ($this->spoke_pivot()->get() as $pivot) {
                $this->sessions += $pivot->sessions->keyBy('id')->all();
            }
            ksort($this->most_visited);
        }
        return $this->sessions;
    }

    /**
     * @todo we should differentiate themes he's following, that are taken from his sessions and from the events
     * @todo cache
     * @return Theme[]|Collection
     */
    public function getAllThemesAttribute() {
        if (!$this->all_themes) {
            $this->all_themes = $this->following_events()->get()->keyBy('id')->all();
            foreach ($this->getSessionsAttribute() as $session) {
                $this->all_themes += $session->themes->keyBy('id')->all();
            }
            foreach ($this->getEventsAttribute() as $event_data) {
                $this->all_themes += $event_data['event']->themes->keyBy('id')->all();
            }
            ksort($this->most_visited);
        }
        return $this->all_themes;
    }
}
