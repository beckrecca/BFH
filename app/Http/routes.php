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

Route::get('/', function () {
    return view('welcome');
});

/** MAIN MAP **/
Route::get('map', 'HikeController@map');

/** EXPLORE **/
Route::get('explore', 'HikeController@explore');
Route::post('explore', 'HikeController@postExplore');

/** HIKES **/
Route::get('hikes/climb/{climb}', 'HikeController@climb');
Route::get('hikes/{path_name}', 'HikeController@detail');
Route::get('hikes/distance/{n}', 'HikeController@distance');

/** SUGGEST **/
Route::get('suggest', function() {
    return view('hikes.suggest');
});

/** IMAGES **/
//Route::get('hikes/{path_name}/images', 'ImageController@View');

/** LINES **/
Route::get('lines/{id}', 'LineController@view');
Route::get('service/{name}', 'LineController@service');

/** TAGS **/
Route::get('tags/{id}', 'TagController@view');
//Route::get('tags', 'TagController@all');

/** EXTRAS **/
Route::get('disclaimer', function() {
    return view('disclaimer');
});

/** TESTING ROUTES **/
Route::get('/lines/hike/{id}', function ($id) {
    $lines = \App\Line::byHikes($id);
    return $lines;
});
Route::get('/debug', function() {

    echo '<pre>';

    echo '<h1>Environment</h1>';
    echo App::environment().'</h1>';

    echo '<h1>Debugging?</h1>';
    if(config('app.debug')) echo "Yes"; else echo "No";

    echo '<h1>Database Config</h1>';
    /*
    The following line will output your MySQL credentials.
    Uncomment it only if you're having a hard time connecting to the database and you
    need to confirm your credentials.
    When you're done debugging, comment it back out so you don't accidentally leave it
    running on your live server, making your credentials public.
    */
    //print_r(config('database.connections.mysql'));

    echo '<h1>Test Database Connection</h1>';
    try {
        $results = DB::select('SHOW DATABASES;');
        echo '<strong style="background-color:green; padding:5px;">Connection confirmed</strong>';
        echo "<br><br>Your Databases:<br><br>";
        print_r($results);
    }
    catch (Exception $e) {
        echo '<strong style="background-color:crimson; padding:5px;">Caught exception: ', $e->getMessage(), "</strong>\n";
    }

    echo '</pre>';

});