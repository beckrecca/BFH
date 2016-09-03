<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    /**
	* Each Line lies on one or many Markers and vice versa.
	* This function defines that relationship.
	**/
	public function markers()
	{
		# define a many-to-many relationship
	    return $this->belongsToMany('\App\Marker');
	}
}
