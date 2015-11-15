<?php namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use LaravelArdent\Ardent\Ardent;

_('Personal website'); //just so gettext finds our unique "social network" that needs translation :)

/**
 * @property string name
 * @property string url
 * @property string icon
 * @property int position
 * @property SocialLink links
 * @method HasMany links
 */
class SocialNetwork extends Ardent {

    public $timestamps = false;

    public static $relationsData = [
        'links' => [self::HAS_MANY, SocialLink::class, 'foreignKey' => 'social_network_id', 'relation' => 'social_links'],
    ];

    /**
     * Finds a SocialNetwork by its ID or name (case-insensitive)
     * @todo these results should be cached to improve website performance. Ideally, all entries would be fetched at once and inside this method we would retrieve from cache - if not found, run the current implementation
     * @param int|string $id_or_name
     * @param array $columns
     * @return self
     */
    public static function find($id_or_name, $columns = ['*']) {
        if (is_numeric($id_or_name)) {
            return parent::find($id_or_name, $columns);
        } else {
            return static::whereRaw('LOWER(name) = ?', [$id_or_name])->firstOrFail();
        }
    }

}
