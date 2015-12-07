<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int                       id
 * @property string                    title
 * @property string                    description
 * @property Carbon                    begin
 * @property Carbon                    end
 *
 * @property Event                     event
 * @property Collection|Theme[]        themes
 * @property Collection|EventSpeaker[] speakers_pivot
 * @property Collection|User[]         speakers
 *
 * @method BelongsTo event
 * @method BelongsToMany themes
 * @method BelongsToMany speakers_pivot
 */
class Session extends Base {

    protected $speakers = [];

    protected $dates = ['created_at', 'updated_at', 'begin', 'end'];

    protected $dateFormat = 'Y-m-d H:i:sO';

    public static $relationsData = [
        'event'          => [self::BELONGS_TO, Event::class],
        'themes'         => [self::BELONGS_TO_MANY, Theme::class, 'table' => 'session_theme'],
        'speakers_pivot' => [self::BELONGS_TO_MANY, EventSpeaker::class, 'table' => 'session_speaker'],
    ];

    public function getSpeakersAttribute() {
        if (!$this->speakers) {
            foreach ($this->speakers_pivot()->get() as $pivot) { /** @var EventSpeaker $pivot */
                $this->speakers[] = $pivot->user;
            }
            $this->speakers = Collection::make($this->speakers);
        }

        return $this->speakers;
    }

}
