<?php

/** @link http://laravel.com/docs/5.1/routing */
/** @link http://laravel.com/docs/5.1/controllers#implicit-controllers */

/** id_slug pattern is defined at {@link \App\Providers\RouteServiceProvider} */

/************************************************************/
/* ******************** ROUTE PRESETS ********************* */
/************************************************************/
// These would conflict with controller routes, so they need to be set before them
Route::post('user/sign-up', ['uses' => 'UserController@postSignUp', 'before' => 'csrf']);
Route::get( 'event/{id_slug}',         'EventController@getDetails');


/************************************************************/
/* ******************** GENERIC ROUTES ******************** */
/************************************************************/
Route::controller('user',     'UserController');
Route::controller('speakers', 'SpeakerController');
Route::controller('event',    'EventController');


/************************************************************/
/* ****************** ADDITIONAL ROUTES ******************* */
/************************************************************/
Route::get('user/{id_slug}',    'UserController@getProfile');
Route::get('event/search',      'EventController@getSearch'); /** @link https://github.com/laravel/framework/issues/10659 */
Route::get('speaker/{id_slug}', 'UserController@getSpeaker');


/************************************************************/
/* ************** CATCH-ALL / MAIN ROUTES ***************** */
/************************************************************/
Route::controller('/', 'SiteController');
