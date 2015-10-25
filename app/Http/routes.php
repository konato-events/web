<?php

/** @link http://laravel.com/docs/5.1/routing */
/** @link http://laravel.com/docs/5.1/controllers#implicit-controllers */

/************************************************************/
/* ******************** ROUTE PRESETS ********************* */
/************************************************************/
// These would conflict with controller routes, so they need to be set before them
Route::get('user/{id_slug}', 'UserController@getProfile');


/************************************************************/
/* ******************** GENERIC ROUTES ******************** */
/************************************************************/
Route::controller('user',       'UserController');
Route::controller('speakers',   'SpeakerController');
Route::controller('event',      'EventController');


/************************************************************/
/* ******************* ROUTE OVERRIDES ******************** */
/************************************************************/
Route::get('event/search',      'EventController@getSearch'); /** @link https://github.com/laravel/framework/issues/10659 */
Route::get('speaker/{id_slug}', 'UserController@getSpeaker');


/************************************************************/
/* ************** CATCH-ALL / MAIN ROUTES ***************** */
/************************************************************/
Route::controller('/',          'SiteController');
