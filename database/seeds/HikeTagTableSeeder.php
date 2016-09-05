<?php

use Illuminate\Database\Seeder;

class HikeTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve JSON file of paired hike and tag IDs
        $json = File::get("database/data/hike_tag.json");
        // Decode the JSON data
        $data = json_decode($json); 
        // for each hike tag pair, insert into table
        foreach ($data as $obj) {
        	/**
        	* Adapted from Sam Deering's article
        	* http://www.fullstack4u.com/laravel/laravel-5-load-seed-data-from-json/
        	**/
	         DB::table('hike_tag')->insert([
		        'hike_id' => $obj->hike_id,
		        'tag_id' => $obj->tag_id
	    	]);
   		 }
    }
}
