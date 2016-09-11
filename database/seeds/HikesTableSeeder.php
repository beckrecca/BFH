<?php

use Illuminate\Database\Seeder;

class HikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve JSON file of hikes
        $json = File::get("database/data/hikes.json");
        // Decode the JSON data
        $data = json_decode($json); 
        // for each hike, insert into table
        foreach ($data as $obj) {
        	/**
        	* Adapted from Sam Deering's article
        	* http://www.fullstack4u.com/laravel/laravel-5-load-seed-data-from-json/
        	**/
	         DB::table('hikes')->insert([
		        'name' => $obj->name,
		        'path_name' => $obj->path_name,
		        'description' => $obj->description,
		        'climb' => $obj->climb,
		        'web' => $obj->web
	    	]);
   		 }
    }
}
