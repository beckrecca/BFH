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

	/*
	* Each Hike is adjacent to at least one MBTA line.
	* This function accepts a hike ID and returns a collection
	* of all the adjacent lines.
	**/
	public static function byHikes($id)
	{
		// get the hike
		$hike = \App\Hike::find($id);

		// get the markers for this hike
		$markers = $hike->markers;

		// initialize a collection of lines
		$lines = collect();

		// get the lines for each marker
		foreach ($markers as $marker) {
			$linesByMarker = $marker->lines;
			// for each line
			foreach ($linesByMarker as $line) {
				// if the lines collection does not already have this line
				if (!$lines->contains('id', $line->id)) {
					// add it to the lines collection
					$lines = $lines->push($line);
				}
			}
		}

		// remove any duplicates
		$lines->unique();

		// return the results
		return $lines;
	}
}
