<?php
namespace App\Http\Requests;

/**
 * Model requests automatically discover their model rules given their classnames.
 * Models are autoloaded from \App\Models namespace.
 * @todo could this be done directly inside the Ardent's model class?
 * @package App\Http\Requests
 */
abstract class Model extends Request {

    public function rules() {
        /** @var \LaravelArdent\Ardent\Ardent $model */
        $model = '\App\Models\\'.class_basename(static::class);
        return $model::$rules;
    }

}
