<?php

use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve JSON file of images
        $json = File::get("database/data/images.json");
        // Decode the JSON data
        $data = json_decode($json); 
        // for each image, insert into table
        foreach ($data as $obj) {
        	/**
        	* Adapted from Sam Deering's article
        	* http://www.fullstack4u.com/laravel/laravel-5-load-seed-data-from-json/
        	**/
	         DB::table('images')->insert([
		        'file' => $obj->file,
		        'alt' => $obj->alt,
		        'title' => $obj->title,
		        'hike_id' => $obj->hike_id,
	    	]);
   		 }
    }
}
