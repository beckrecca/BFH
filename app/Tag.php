<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
    * Each Tag has one or multiple Hikes and vice versa.
    * This function defines that relationship.
    **/
    public function hikes()
    {
        # define a many-to-many relationship
        return $this->belongsToMany('\App\Hike');
    }

    /**
    * Some tags have special messages with important information.
    * This function determines if the passed tag has a message.
    **/
    public function special()
    {
    	//
    }
}
