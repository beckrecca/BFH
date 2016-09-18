<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TagController extends Controller
{
    /**
    * Responds to requests to GET /tags/{id}
    * Renders the page showing all hikes with that tag
    */
    public function view($id) 
    {
        // try to obtain the tag by this ID
        try {
            $tag = \App\Tag::find($id);
        }
        catch(exception $e) {
            return Redirect::to('errors.404');
        }
    	
    	// find all hikes with this ID, sorted alphabetically
    	$hikes = $tag->hikes->sortBy('name');
    	return view ('tags.view')->with('tag', $tag)
                                 ->with('hikes', $hikes);
    }
}
