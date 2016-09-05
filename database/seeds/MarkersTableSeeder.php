<?php

use Illuminate\Database\Seeder;

class MarkersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve JSON file of markers
        $json = File::get("database/data/markers.json");
        // Decode the JSON data
        $data = json_decode($json); 
        // for each marker, insert into table
        foreach ($data as $obj) {
        	/**
        	* Adapted from Sam Deering's article
        	* http://www.fullstack4u.com/laravel/laravel-5-load-seed-data-from-json/
        	**/
	         DB::table('markers')->insert([
		        'name' => $obj->name,
		        'address' => $obj->address,
		        'lat' => $obj->lat,
		        'lng' => $obj->lng,
		        'hike_id' => $obj->hike_id,
		        'distance_to_mbta' => $obj->distance_to_mbta
	    	]);
   		 }
    }
}
