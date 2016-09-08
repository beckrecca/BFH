<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HikeController extends Controller
{
    // Render the view of the hiking page.
    public function hike($path_name) 
    {
    	$hike = \App\Hike::where('path_name', '=', $path_name)->first();
    	$markers = $hike->markers;
    	return view ('hikes.detail')->with('hike', $hike)
    								->with('markers', $markers);
    }
}
