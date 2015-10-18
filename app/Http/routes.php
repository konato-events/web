<?php

/** @link http://laravel.com/docs/5.1/routing
 *  @link http://laravel.com/docs/5.1/controllers#implicit-controllers */

//Route::controller('user',       'UserController');
Route::controller('speakers',   'SpeakerController');
Route::get('speaker/{id_slug}', 'SpeakerController@getProfile');
Route::controller('event',      'EventController');
Route::controller('/',          'SiteController');
