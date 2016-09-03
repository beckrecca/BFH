<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    /**
	* Each Marker is close to one or many Lines and vice versa.
	* This function defines that relationship.
	**/
	public function lines()
	{
		# define a many-to-many relationship
	    return $this->belongsToMany('\App\Line');
	}
}
