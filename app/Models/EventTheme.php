<?php namespace App\Models;

/**
 * @property int event_id
 * @property int theme_id
 */
class EventTheme extends Base {

    protected $table = 'event_theme';
    protected $primaryKey = 'event_id';

}
