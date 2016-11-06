<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

class HikeController extends Controller
{
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
    * Responds to requests to GET /explore
    * Renders the explore page form
    */
    public function explore() 
    {
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
        
        return view ('hikes.explore')->with('features', $features)
                                     ->with('facilities', $facilities)
                                     ->with('sceneries', $sceneries)
                                     ->with('activities', $activities)
                                     ->with('sizes', $sizes);
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

        // Remember whether tags hidden below the buttons were checked
        $tagsChecked = false;

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
        else $results = collect($hikesByDistance);

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
                // Initialize tags intersection and previous results
                $tagIntersectResults;
                $prevResults = collect();
                // initialize counter for hike comparison
                $i = 0;
                // For each tag name selected, create a new Tag object
                foreach ($tags as $tag_name) {
                    $tag = \App\Tag::where('name', '=', $tag_name)->first();
                    // If the category of this tag is any hidden below a button, remember that
                    if ($tag->category != "size") $tagsChecked = true;
                    // mark each checked tag as checked
                    array_push($checked, $tag_name);
                    // Get the hikes for this tag
                    $hikesByTag = $tag->hikes;
                    // Clear tags intersection results
                    $tagIntersectResults = collect();
                    // Remember previous results as comparative results
                    $compResults = $prevResults;
                    // Initialize and clear previous results
                    $prevResults = collect();
                    // for each hikes by tag,
                    foreach ($hikesByTag as $hike) {
                        // if this is the first tag
                        if ($i == 0) {
                            // compare its hikes with the current results
                            if ($results->contains('name', $hike->name)) {
                                // save those results
                                $tagIntersectResults[] = $hike;
                                // also remember them for future comparison
                                $prevResults[] = $hike;
                            }
                        }
                        // if second or later
                        else if ($i > 0) {
                            // compare to previous results
                            if ($compResults->contains('name', $hike->name)) {
                                // save those results
                                $tagIntersectResults[] = $hike;
                                // remember them for future comparison
                                $prevResults[] = $hike;
                            }
                        }
                    }
                    // clear comparative results
                    $compResults = collect();
                    // increment counter
                    $i++;
                }
                // Update results
                $results = $tagIntersectResults;                
            }
        }

        # FORMAT RESULTS
        // Make sure there are no duplicates in the collection
        $results = $results->unique();
        // Alphabetize the results by hike name
        $results = $results->sortBy('name');
        // Count the results
        $count = $results->count();

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
                                    ->with('selected', $selected)
                                    ->with('tagsChecked', $tagsChecked)
                                    ->with('count', $count);
    }

    /**
    * Responds to requests to GET /suggest
    * Renders the suggest page form
    */
    public function suggest()
    {
        // Get all the hikes
        $hikes = \App\Hike::all();
        return view('hikes.suggest')->with('hikes', $hikes);
    }

    /**
    * Responds to requests to POST /suggest
    * Emails the user input for hike suggestions
    * to bostonfarehikes@gmail.com
    */
    public function postSuggest(Request $request)
    {
        # VALIDATION
        $this->validate($request, [
            'name' => 'required|max:160',
            'address' => 'required|max:160',
            'difficulty' => 'required|in:flat,easy,easy-to-moderate,moderate,moderate-to-intense,intense',
            'distance' => 'required|numeric',
            'description' => 'max:250',
            'web' => 'url'
        ]);

        $data = array(
            'request' => $request
        );

        \Mail::send('emails.suggest', $data, function ($message) {
          $message->to('bostonfarehikes@gmail.com')
            ->subject('New Suggestion');
        });

        return view('hikes.suggest')->with('message', 'Thank you! Your suggestion has been accepted.');
    }

    /**
    * Responds to requests to POST /correct
    * Emails the user input for hike corrections
    * to bostonfarehikes@gmail.com
    */
    public function postCorrect(Request $request)
    {
        return $request->all();
    }
}
