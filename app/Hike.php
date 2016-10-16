<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hike extends Model
{
	/**
	* Each Hike has one or many Markers.
	* This function defines that relationship.
	**/
    public function markers() {
        # define a one-to-many relationship.
        return $this->hasMany('\App\Marker');
    }

    /**
	* Each Hike has one or many Images.
	* This function defines that relationship.
	**/
    public function images() {
        # Define a one-to-many relationship.
        return $this->hasMany('\App\Image');
    }

    /**
    * Each Hike has one or multiple Tags and vice versa.
    * This function defines that relationship.
    **/
    public function tags()
    {
        # define a many-to-many relationship
        return $this->belongsToMany('\App\Tag');
    }
    /**
    * Given an instance of markers, iterate through them and 
    * note the hike_ids to which they belong. Return an array of
    * unique hikes.
    */
    public static function byMarkers($markers) {
        // find the hike_id for each marker
        $ids = [];
        foreach ($markers as $marker) {
            array_push($ids, $marker->hike_id);
        }
        // get the hikes by these IDs
        $hikes = \App\Hike::byIds($ids);

        return $hikes;
    }
    /**
    * Given an instance of lines, iterate through them and 
    * get the markers in a relationship with each line. Then,
    * get the hike_ids from those markers. Return an array of
    * unique hikes.
    */
    public static function byLines($lines) {
        // find all the hike ids for these lines
        $ids = [];
        foreach ($lines as $line) {
            $markers = $line->markers;
            foreach ($markers as $marker) {
                array_push($ids, $marker->hike_id);
            }
        }
        
        // get the hikes by these IDs
        $hikes = \App\Hike::byIds($ids);

        return $hikes;
    }
    /**
    * Given an array of hike_ids, return a collection
    * of unique alphabetized hikes.
    **/
    public static function byIds($ids) {
        // remove duplicate hike ids
        $ids = array_unique($ids);

        // form an array of hikes
        $hikes = [];
        foreach ($ids as $id) {
            $hike = \App\Hike::find($id);
            array_push($hikes, $hike);
        }
        // convert to a collection
        $hikes = collect($hikes);
        // alphabetize the hikes
        $hikes = $hikes->sortBy('name');

        return $hikes;
    }
}
