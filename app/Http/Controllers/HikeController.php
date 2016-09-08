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
    	$hike = \App\Hike::where('path_name', '=', $path_name)->first();
    	$markers = $hike->markers;
    	return view ('hikes.detail')->with('hike', $hike)
    								->with('markers', $markers);
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
