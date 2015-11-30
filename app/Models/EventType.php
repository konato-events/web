<?php namespace App\Models;

use App\Models\Traits\Listable;

//TODO: tricking gettext so it gets all our database translations for now (#136)
_('Meeting'); _('Single talk'); _('Talks'); _('Course'); _('Workshop'); _('Conference'); _('Symposium'); _('Congress'); _('University meeting'); _('Entertainment');

/**
 * @property int id
 * @property string name
 * @property Event[] events
 */
class EventType extends Base {

    use Listable;

    public $timestamps = false;

    public static $relationsData = [
        'events' => [self::HAS_MANY, Event::class]
    ];

}
