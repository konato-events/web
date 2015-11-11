<?php
namespace App\Models;
use LaravelArdent\Ardent\Ardent;

class Base extends Ardent {

    /** @todo https://github.com/laravel-ardent/ardent/issues/279 */
    public $throwOnValidation = true;

    /** @todo this should be sent to Ardent itself */
    public static $passwordAttributes = ['password'];

    protected $guarded = ['id', '_token'];

}
