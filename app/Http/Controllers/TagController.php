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
        // obtain the tag by this ID
    	$tag = \App\Tag::find($id);
    	// find all hikes with this ID
    	$hikes = $tag->hikes;
    	return $hikes;
    }
}
