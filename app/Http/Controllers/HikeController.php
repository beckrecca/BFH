<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HikeController extends Controller
{
    /**
    * Responds to requests to GET /hikes
    * Renders the explore page, listing all hikes
    */
    public function all() 
    {
        // grab all of the hikes
        $hikes = \App\Hike::simplePaginate(10);

        // get all the tags
        $tags = \App\Tag::all()->sortBy('name');

        return view ('hikes.explore')->with('hikes', $hikes)
                                     ->with('tags', $tags);
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
}
