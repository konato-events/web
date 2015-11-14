<?php
$root_url  = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'])? 'https' : 'http';
$root_url .= '://'.$_SERVER['HTTP_HOST'];

$auth_provider = function(string $name) use ($root_url) {

    $caps = strtoupper($name);
    return [$name => [
        'client_id'     => env($caps.'_ID'),
        'client_secret' => env($caps.'_SECRET'),
        'redirect'      => $root_url.'/auth/callback/'.$name
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
