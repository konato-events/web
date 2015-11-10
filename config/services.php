<?php
$auth_provider = function(string $name) {
    $caps = strtoupper($name);
    return [$name => [
        'client_id'     => env($caps.'_ID'),
        'client_secret' => env($caps.'_SECRET'),
        'redirect'      => env('APP_ROOT_URL').'/auth/callback/'.$name
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
