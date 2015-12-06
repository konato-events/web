<?php namespace App\Models;

/**
 * @property int    id
 * @property string name
 *
 */
class Theme extends Base {

    protected $speakers = [];

    public static $relationsData = [
        'events'   => [self::BELONGS_TO_MANY, Event::class, 'table' => 'event_theme'],
        'sessions' => [self::BELONGS_TO_MANY, Session::class, 'table' => 'session_theme'],
        'parent'   => [self::BELONGS_TO, self::class],
        'children' => [self::HAS_MANY, self::class],
    ];

    //TODO: improve this query
    public function getSpeakersAttribute() {
        if (!$this->speakers) {
            foreach ($this->sessions as $session) {
                $this->speakers += $session->speakers->keyBy('id');
            }
        }
        return $this->speakers;
    }

}