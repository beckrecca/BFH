<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

class HikeController extends Controller
{
    /**
    * Responds to requests to GET /hikes
    * Renders the explore page, listing all hikes
    */
    public function all() 
    {
        // Grab all of the hikes
        $hikes = \App\Hike::paginate(10);

        # FORM INPUT
        // get all the tags by feature
        $features = \App\Tag::where('category', '=', 'features')->get()->sortBy('name');

        // get all the tags by facilities
        $facilities = \App\Tag::where('category', '=', 'facilities')->get()->sortBy('name');

        // get all the tags by scenery
        $sceneries = \App\Tag::where('category', '=', 'scenery')->get()->sortBy('name');

        // get all the tags by activity
        $activities = \App\Tag::where('category', '=', 'activities')->get()->sortBy('name');

        // get all the tags by size
        $sizes = \App\Tag::where('category', '=', 'size')->get()->sortBy('name');
        
        return view ('hikes.explore')->with('hikes', $hikes)
                                     ->with('features', $features)
                                     ->with('facilities', $facilities)
                                     ->with('sceneries', $sceneries)
                                     ->with('activities', $activities)
                                     ->with('sizes', $sizes);
    }

    /**
    * Responds to requests to GET /hikes/climb/{climb}
    * Shows a list of all the hikes with the given climb rating
    */
    public function climb($climb) {
        // find all hikes with this climb rating
        $hikes = \App\Hike::where('climb', '=', $climb)->get();
        
        return view ('hikes.list')->with('hikes', $hikes)
                                  ->with('climb', $climb);
    }

    /**
    * Responds to requests to GET /hikes/{path-name}
    * Renders the detail page for that particular hike
    */
    public function detail($path_name) 
    {
        // obtain the first (and only) hike by this path name
    	$hike = \App\Hike::where('path_name', '=', $path_name)->first();

        // get this hike's entrance markers
    	$markers = $hike->markers;

        // get this hike's photos
        $images = $hike->images;

        // get this hike's tags in alphabetical order
        $tags = $hike->tags->sortBy('name');

    	return view ('hikes.detail')->with('hike', $hike)
                                    ->with('images', $images)
    								->with('markers', $markers)
                                    ->with('tags', $tags);
    }
    /**
    * Responds to requests to GET /hikes/distance/{n}
    * Lists all the hikes within $n miles from the MBTA
    */
    public function distance($n) 
    {
        // obtain the markers with this distance_to_MBTA
        $markers = \App\Marker::where('distance_to_mbta', '<=', $n)->get();

        // find all the hikes that own these markers
        $hikes = \App\Hike::byMarkers($markers);

        return view ('hikes.list')->with('hikes', $hikes)
                                  ->with('distance', $n);
    }

    /**
    * Responds to requests to GET /
    * Renders the main page with map and all markers and find nearest form
    */
    public function map()
    {
        // get all the hikes
        $hikes = \App\Hike::all()->sortBy('name');

        // get all the markers
        $markers = \App\Marker::all();

        return view('hikes.map')->with('hikes', $hikes)
                                ->with('markers', $markers);
    }

    /**
    * Responds to requests to POST /explore
    * Validates form submission and finds hikes matching the
    * user's selection.
    */
    public function postExplore(Request $request)
    {
        # VALIDATION
        // Validate the data
        $validator = Validator::make($request->all(), [
            'climbs' => 'array',
            'distance' => 'numeric',
            'services' => 'array',
            'tags' => 'array',
        ]);

        // Handle validation failure
        if ($validator->fails()) {
            return redirect('/explore')
                        ->withErrors($validator)
                        ->withInput();
        }

        # SEARCH RESULTS
        // Inititalize results collection
        $results = collect();

        // Get the distance selected
        $distance = $request->distance;

        // Remember which values have been selected
        $selected = $distance;

        // Get the climb rating(s) selected
        $climbs = $request->climbs;

        // Get the service(s) selected
        $services = $request->services;

        // Get the tag(s) selected
        $tags = $request->tags;

        // Remember which values have been checked
        $checked = [];

        # DISTANCE FILTER
        // For the distance selection, find all the markers within that distance
        $markers = \App\Marker::where('distance_to_mbta', '<=', $distance)->get();

        // Retrieve all of the hikes for those markers
        $hikesByDistance = \App\Hike::byMarkers($markers);

        #CLIMB FILTER
        // For each climb rating, filter the hikes
        if (isset($climbs)) {
            if (!empty($climbs)) {
                foreach ($climbs as $climb) {
                    $filteredByClimb = $hikesByDistance->filter(function ($hike) use ($climb) {
                        return $hike->climb == $climb;
                    });
                    // remember this climb value was checked
                    array_push($checked, $climb);
                    // Merge this with our results
                    $results = $results->merge($filteredByClimb);
                }
            }
        }
        else $results = $hikesByDistance;

        # SERVICE FILTER
        // For each service selected, filter the hikes
        if (isset($services)) {
            if (!empty($services)) {
                // find all the lines belonging to these services
                $lines = \App\Line::whereIn('service', $services)->get();
                // find all of the hikes adjacent to these lines
                $hikesByService = \App\Hike::byLines($lines);
                // mark each selected service as checked
                foreach ($services as $service) {
                    array_push($checked, $service);
                }
                // intersect these hikes with the current results
                $results = $results->intersect($hikesByService);
            }
        }
        # TAG FILTER
        if (isset($tags)) {
            if (!empty($tags)) {
                // initialize hikes by tags collection
                $hikesByTag = collect();
                // Keep an array of the collections of hike IDs
                $collectionArray = [];
                // find the hikes associated with each tag
                foreach ($tags as $tag) {
                    // initialize a Tag object by the tag name selected by the user
                    $newTag = \App\Tag::where('name', '=', $tag)->first();
                    // obtain the hikes with this tag
                    $hikes = $newTag->hikes;
                    // Identify the hikes by IDs
                    $hikeIDs = collect();
                    // get the IDs for all the hikes of this tag
                    foreach ($hikes as $hike) $hikeIDs = $hikeIDs->merge($hike->id);
                    // remember those IDs as a collection in one row per tag
                    array_push($collectionArray, $hikeIDs);
                }
                // Initialize intersected IDs collection
                $ids = collect();
                // Intersect each row in the collection array until there is only one
                for ($i = 0; $i < count($collectionArray); $i++) {
                    // if this is the first index, instantiate ids array
                    if ($i == 0) $ids = $collectionArray[0];
                    // if this is the second index, intersect
                    else if ($i == 1) $ids = $collectionArray[0]->intersect($collectionArray[$i]);
                    // if this is any index beyond, intersect with ids
                    else $ids = $ids->intersect($collectionArray[$i]);
                    return $ids;
                }
                return $ids;
            }
        }

        # FORMAT RESULTS
        // Make sure there are no duplicates in the collection
        $results = $results->unique();
        // Alphabetize the results by hike name
        $results = $results->sortBy('name');

        # FORM INPUT
        // get all the tags by feature
        $features = \App\Tag::where('category', '=', 'features')->get()->sortBy('name');

        // get all the tags by facilities
        $facilities = \App\Tag::where('category', '=', 'facilities')->get()->sortBy('name');

        // get all the tags by scenery
        $sceneries = \App\Tag::where('category', '=', 'scenery')->get()->sortBy('name');

        // get all the tags by activity
        $activities = \App\Tag::where('category', '=', 'activities')->get()->sortBy('name');

        // get all the tags by size
        $sizes = \App\Tag::where('category', '=', 'size')->get()->sortBy('name');

        return view('hikes.explore')->with('hikes', $results)
                                    ->with('features', $features)
                                    ->with('facilities', $facilities)
                                    ->with('sceneries', $sceneries)
                                    ->with('activities', $activities)
                                    ->with('sizes', $sizes)
                                    ->with('checked', $checked)
                                    ->with('selected', $selected);
    }
}
