<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HikeController extends Controller
{
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
        // get this hike's tags
        $tags = $hike->tags;
    	return view ('hikes.detail')->with('hike', $hike)
                                    ->with('images', $images)
    								->with('markers', $markers)
                                    ->with('tags', $tags);
    }

    /**
    * Responds to requests to GET /hikes
    * Renders the explore page, listing all hikes
    */
    public function all() 
    {
    	$hikes = \App\Hike::all();
    	return view ('hikes.explore')->with('hikes', $hikes);
    }
}
