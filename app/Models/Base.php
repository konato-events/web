<?php namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use LaravelArdent\Ardent\Ardent;

/**
 * @property string slug
 */
class Base extends Ardent {

    const ERR_UNIQUE_VIOLATION = 23505;

    /** @todo https://github.com/laravel-ardent/ardent/issues/279 */
    public $throwOnValidation = true;
//    public static $throwOnFind = true;

    public $autoHydrateEntityFromInput = true;
    public $autoPurgeRedundantAttributes = true;

    /** @todo this should be sent to Ardent itself */
    public static $passwordAttributes = ['password'];

    protected $guarded = ['id', '_token'];

    protected $slug;

    /** Field to be used as text part in the slug
     * @var string */ 
    protected static $slugText;

    //TODO: replace all slugify calls with this?
    public function getSlugAttribute() {
        if (!$this->slug) {
            $this->slug = slugify(
                $this->getKey(),
                isset(static::$slugText)?
                    $this->{static::$slugText} :
                    ($this->name ?? $this->title ?? '')
            );
        }
        return $this->slug;
    }

    public static function firstOrCreate(array $attributes) {
        /** @var Builder $query */
        $query = (new static)->newQueryWithoutScopes();
        foreach ($attributes as $name => &$value) {
            if (is_array($value)) {
                $query->where($name, $value[0], $value[1]);
                $value = $value[1];
            } else {
                $query->where($name, $value);
            }
        }

        if (!is_null($instance = $query->first())) {
            return $instance;
        } else {
            return static::create($attributes);
        }
    }

}
