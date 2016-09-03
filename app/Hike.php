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
}
