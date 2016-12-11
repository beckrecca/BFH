<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/** MAIN MAP **/
Route::get('/', 'HikeController@map');
Route::get('/map', 'HikeController@map');

/** EXPLORE **/
Route::get('explore', 'HikeController@explore');
Route::post('explore', 'HikeController@postExplore');

/** HIKES **/
Route::get('hikes/climb/{climb}', 'HikeController@climb');
Route::get('hikes/{path_name}', 'HikeController@detail');
Route::get('hikes/distance/{n}', 'HikeController@distance');

/** SUGGEST **/
Route::get('suggest', 'HikeController@suggest');
Route::post('suggest', 'HikeController@postSuggest');
Route::post('correct', 'HikeController@postCorrect');

/** LINES **/
Route::get('lines/{id}', 'LineController@view');
Route::get('service/{name}', 'LineController@service');

/** TAGS **/
Route::get('tags/{id}', 'TagController@view');

/** EXTRAS **/
Route::get('disclaimer', function() {
    return view('disclaimer');
});
Route::get('about', function() {
    return view('about');
});