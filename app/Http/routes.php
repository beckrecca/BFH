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

/** TESTING ROUTES **/

Route::get('hike/{id}', function($id) {
    return App\Hike::find($id);
});
Route::get('allhikes', function() {
    return \App\Hike::all();
});
Route::get('hike-markers/{id}', function($id) {
    $hike = App\Hike::find($id);
    $markers = (string) $hike->markers;
    var_dump($markers);
});
Route::get('marker/{id}', function($id) {
    return \App\Marker::find($id);
});
Route::get('allmarkers', function() {
    return \App\Marker::all();
});
Route::get('marker-lines/{id}', function($id) {
    $marker = App\Marker::find($id);
    $lines = (string) $marker->lines;
    var_dump($lines);
});
Route::get('line/{id}', function($id) {
    return \App\Line::find($id);
});
Route::get('alllines', function() {
    return \App\Line::all();
});
Route::get('line-markers/{id}', function($id) {
    $line = App\Line::find($id);
    $markers = (string) $line->markers;
    var_dump($markers);
});
Route::get('tag/{id}', function($id) {
    return \App\Tag::find($id);
});
Route::get('alltags', function() {
    return \App\Tag::all();
});
Route::get('hike-tags/{id}', function($id) {
    $hike = App\Hike::find($id);
    $tags = (string) $hike->tags;
    var_dump($tags);
});
Route::get('image/{id}', function($id) {
    return \App\Image::find($id);
});
Route::get('allimages', function() {
    return \App\Image::all();
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