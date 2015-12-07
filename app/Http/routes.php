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
Route::controller('auth',         'AuthController');
Route::controller('user',         'UserController');
Route::controller('event',        'EventController');
Route::controller('theme',        'ThemeController');
Route::controller('autocomplete', 'AutoCompleteController');


/************************************************************/
/* ****************** ADDITIONAL ROUTES ******************* */
/************************************************************/
Route::get('user/{id_slug}',    'UserController@getProfile');
Route::get('event/search',      'EventController@getSearch'); /** @link https://github.com/laravel/framework/issues/10659 */
Route::get('speaker/{id_slug}', 'UserController@getSpeaker');


/************************************************************/
/* ************** CATCH-ALL / MAIN ROUTES ***************** */
/************************************************************/

//imported from vendor/barryvdh/laravel-debugbar/src/ServiceProvider.php:72
//TODO: without re-declaring those here, the SiteController catch-all would get precedence
Route::get('_debugbar/open', ['uses' => 'OpenHandlerController@handle', 'as' => 'debugbar.openhandler']);
Route::get('_debugbar/clockwork/{id}', ['uses' => 'OpenHandlerController@clockwork', 'as' => 'debugbar.clockwork']);
Route::get('_debugbar/assets/stylesheets', ['uses' => 'AssetController@css', 'as' => 'debugbar.assets.css']);
Route::get('_debugbar/assets/javascript', ['uses' => 'AssetController@js', 'as' => 'debugbar.assets.js']);

Route::controller('/', 'SiteController');
