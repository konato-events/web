<?php

/** @link http://laravel.com/docs/5.1/routing */
/** @link http://laravel.com/docs/5.1/controllers#implicit-controllers */

//Route::controller('user',       'UserController');
Route::controller('speakers',   'SpeakerController');
Route::controller('event',      'EventController');


/************************************************************/
/* ******************* ROUTE OVERRIDES ******************** */
/************************************************************/
Route::get('speaker/{id_slug}', 'SpeakerController@getProfile');
Route::get('event/search',      'EventController@getSearch'); /** @link https://github.com/laravel/framework/issues/10659 */


/************************************************************/
/* ************** CATCH-ALL / MAIN ROUTES ***************** */
/************************************************************/
Route::controller('/',          'SiteController');