<?php
namespace App\Models;
use LaravelArdent\Ardent\Ardent;

class Base extends Ardent {

    /** @todo https://github.com/laravel-ardent/ardent/issues/279 */
    public $throwOnValidation = true;

}
