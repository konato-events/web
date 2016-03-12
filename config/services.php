<?php
if (!defined('ROOT_URL')) {
    $root_url  = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'])? 'https' : 'http';
    $root_url .= '://'.($_SERVER['HTTP_HOST']?? 'localhost:81');
    define('ROOT_URL', $root_url);
}

$auth_provider = function(string $name) {
    $caps = strtoupper($name);
    return [$name => [
        'client_id'     => env($caps.'_ID'),
        'client_secret' => env($caps.'_SECRET'),
        'redirect'      => ROOT_URL.'/auth/callback/'.$name
    ]];
};

return array_merge(
    $auth_provider('facebook'),
//    $auth_provider('facebook'),
//    $auth_provider('facebook'),
//    $auth_provider('facebook'),
    [

    ]
);
