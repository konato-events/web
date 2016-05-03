<?php
if (!defined('ROOT_URL')) {
    $root_url  = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'])? 'https' : 'http';
    $root_url .= '://'.($_SERVER['HTTP_HOST']?? 'localhost:81');
    define('ROOT_URL', $root_url);
}

$providers = ['facebook','twitter','linkedin','google','github','bitbucket','live'];
return array_merge(
    array_map(function($name) {
        $caps = strtoupper($name);
        return [
            'client_id'     => env($caps.'_ID'),
            'client_secret' => env($caps.'_SECRET'),
            'redirect'      => ROOT_URL.'/auth/callback/'.$name
        ];
    }, array_combine($providers, $providers)),
    [/* other things? */]
);
