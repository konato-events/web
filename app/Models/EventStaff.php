<?php namespace App\Models;
use Carbon\Carbon;

/**
 * @property int    event_id
 * @property int    user_id
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class EventStaff extends Base {
    protected $table      = 'event_staff';
    protected $primaryKey = 'event_id';
}
