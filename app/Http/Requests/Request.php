<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest {

    /**
     * Determine if the request passes the authorization check. Defaults to true, different from the original method.
     * @return bool
     */
    protected function passesAuthorization() {
        if (method_exists($this, 'authorize')) {
            return $this->container->call([$this, 'authorize']);
        }

        return true;
    }
}
