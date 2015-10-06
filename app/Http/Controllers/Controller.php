<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {
    use DispatchesJobs, ValidatesRequests;

    public static function getParam($name, $default = null) {
        return self::param($_GET, $name, $default);
    }

    public static function postParam($name, $default = null) {
        return self::param($_POST, $name, $default);
    }

    private static function param($global, $name, $default) {
        return (isset($global[$name]) && !empty($global[$name]))? $global[$name] : $default;
    }
}
