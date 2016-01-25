<?php namespace App\Models;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\File\UploadedFile;

//tricking gettext to find our four participation types
_('participant'); _('speaker'); _('involved'); _('staff');

/**
 * @property int                       id
 * @property string                    name
 * @property string                    email
 * @property string                    password
 * @property string                    username
 * @property string                    tagline
 * @property string                    bio
 * @property Carbon                    birthday
 * @property string                    gender
 * @property string                    avatar
 * @property string                    picture
 *
 * @property int[]                     stats
 * @property array                     events
 * @property array                     most_visited
 *
 * @property Collection|SocialLink[]   links
 * @property Location                  location
 * @method BelongsTo                 location
 * @property Collection|User[]         follows
 * @method BelongsToMany             follows
 * @property Collection|User[]         followed_by
 * @method BelongsToMany             followed_by
 * @property Collection|Event[]        participated
 * @method BelongsToMany             participated
 * @property Collection|Event[]        organized
 * @method BelongsToMany             organized
 * @property Collection|Event[]        spoke
 * @method BelongsToMany             spoke
 * @property Collection|Event[]        following_events
 * @method BelongsToMany             following_events
 * @property Collection|Theme[]        following_themes
 * @method BelongsToMany             following_themes
 * @property Collection|EventSpeaker[] spoke_pivot
 * @method HasMany spoke_pivot
 * @property Collection|Session[]      sessions
 * @property Collection|Theme[]        all_themes
 */
class User extends Base implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword, Traits\Gravatar;

    protected $hidden                     = ['password', /*'remember_token'*/];

    protected $dates                      = ['created_at', 'updated_at', 'birthday'];

    public    $autoHashPasswordAttributes = true;

    protected $most_visited               = [];
    protected $events                     = [];
    protected $sessions                   = [];
    protected $all_themes                 = [];

//    public $autoHydrateEntityFromInput = true;

    const PARTICIPANT             = 'participant';
    const SPEAKER                 = 'speaker';
    const INVOLVED                = 'involved'; //todo: include a "voluntary" or "lesser staff" role
    const STAFF                   = 'staff';
    const PARTICIPATION_RELATIONS = [
        'participated' => self::PARTICIPANT,
        'spoke'        => self::SPEAKER,
        'organized'    => self::STAFF,
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
        'birthday' => ['date', /*'after:6 years', 'before:1875-02-21'*/],
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
            'foreignKey' => 'follower_id',
            'timestamps' => true
        ],
        'followed_by'      => [
            self::BELONGS_TO_MANY,
            self::class,
            'table'      => 'following_user',
            'otherKey'   => 'follower_id',
            'timestamps' => true
        ],
        'spoke'            => [
            self::BELONGS_TO_MANY,
            Event::class,
            'table'     => 'event_speaker',
            'pivotKeys' => ['important']
        ],
        'spoke_pivot'      => [self::HAS_MANY, EventSpeaker::class],
        'organized'        => [self::BELONGS_TO_MANY, Event::class, 'table' => 'event_staff'],
        'participated'     => [self::BELONGS_TO_MANY, Event::class, 'table' => 'participating_event'],
        'following_events' => [self::BELONGS_TO_MANY, Event::class, 'table' => 'following_event', 'timestamps' => true],
        'following_themes' => [self::BELONGS_TO_MANY, Theme::class, 'table' => 'following_theme', 'timestamps' => true],
        //'links'          => [self::HAS_MANY, SocialLink::class], //defined by method as we need ordering here
    ];

    public static function findSpeakers() {
        $ids = \DB::table('event_speaker')->select('user_id')->distinct()->get();
        return self::whereIn('id', array_column($ids, 'user_id'))->get();
    }

    public function links() {
        return $this->hasMany(SocialLink::class)->join('social_networks AS n', 'n.id', '=', 'social_network_id')
                    ->orderBy('n.position');
    }

    public function beforeSave() {
//        unset($this->password_confirmation);
        $this->avatar  = $this->avatar  ?? self::generateGravatar($this->email, 100);
        $this->picture = $this->picture ?? self::generateGravatar($this->email, 1920);
    }

    //TODO: cache
    public function getStatsAttribute() {
        $stats = [];
        foreach (static::PARTICIPATION_RELATIONS as $relation => $name) {
            $stats[$name] = $this->$relation()->count();
        }

        return $stats;
    }

    public function setBirthdayAttribute($date) {
        $this->attributes['birthday'] = $date?: null;
    }

    public function setPictureAttribute($file) {
        if (is_string($file)) {
            $path = $file; //TODO: should we copy the picture to our storage instead?
        } elseif ($file instanceof UploadedFile) {
            //no $file->guessExtension() as this would create dups if the user uploads a pic with a different extension
            $rel_path = 'users/picture-'.$this->id;
            $stored   = \Storage::put($rel_path, file_get_contents($file->getRealPath()));
            if (!$stored) {
                $this->errors()->add('picture', _('Sorry, we were unable to save your picture. Can you try again later?'));
            }
            $path = \Config::get('filesystems.root_url').$rel_path;
        }

        if (isset($path)) {
            //FIXME: resize the picture to create a smaller avatar (what size?)
            $this->picture = $this->avatar = $path;
        }
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
            $this->all_themes = $this->following_themes()->get()->keyBy('id')->all();
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
