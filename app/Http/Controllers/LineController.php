<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class LineController extends Controller
{
    /**
    * Responds to requests to GET /lines/{id}
    * Renders the page showing all hikes with that tag
    */
    public function view($id) 
    {
        // try to obtain the line by this ID
        try {
            $line = \App\Line::findOrFail($id);
        }
        catch(exception $e) {
            return Redirect::to('errors.404');
        }
    	
    	// find all markers with this ID
    	$markers = $line->markers;

    	// find the hike_id for each marker
    	$ids = [];
    	foreach ($markers as $marker) {
    		array_push($ids, $marker->hike_id);
    	}
    	// remove duplicate hike ids
    	$ids = array_unique($ids);

    	// form an array of hikes
    	$hikes = [];
    	foreach ($ids as $id) {
    		$hike = \App\Hike::find($id);
    		array_push($hikes, $hike);
    	}

    	return view ('lines.view')->with('line', $line)
    						      ->with('hikes', $hikes);
    }
    /**
    * Responds to requests to GET /service/{name}
    * Renders the page showing all hikes accessible by that service
    */
    public function service($name) 
    {
        // find all the lines belonging to this service
        $lines = \App\Line::where('service', '=', $name)->get();

        // find all the hike ids for these lines
        $ids = [];
        foreach ($lines as $line) {
            $markers = $line->markers;
            foreach ($markers as $marker) {
                array_push($ids, $marker->hike_id);
            }
        }
        // remove duplicate hike ids
        $ids = array_unique($ids);

        // form an array of hikes
        $hikes = [];
        foreach ($ids as $id) {
            $hike = \App\Hike::find($id);
            array_push($hikes, $hike);
        }
        sort($hikes);

        return view ('lines.list')->with('service', $name)
                                  ->with('hikes', $hikes);
    }
}
