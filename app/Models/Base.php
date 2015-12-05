<?php
namespace App\Models;
use LaravelArdent\Ardent\Ardent;

/**
 * @property string slug
 */
class Base extends Ardent {

    /** @todo https://github.com/laravel-ardent/ardent/issues/279 */
    public $throwOnValidation = true;
//    public static $throwOnFind = true;

    public $autoHydrateEntityFromInput = true;
    public $autoPurgeRedundantAttributes = true;

    /** @todo this should be sent to Ardent itself */
    public static $passwordAttributes = ['password'];

    protected $guarded = ['id', '_token'];

    //TODO: replace all slugify calls with this?
    public function getSlugAttribute() {
        return slugify($this->{$this->primaryKey}, ($this->name ?? $this->title) ?? '');
    }

}
