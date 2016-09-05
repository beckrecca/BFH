<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve JSON file of tags
        $json = File::get("database/data/tags.json");
        // Decode the JSON data
        $data = json_decode($json); 
        // for each tag, insert into table
        foreach ($data as $obj) {
        	/**
        	* Adapted from Sam Deering's article
        	* http://www.fullstack4u.com/laravel/laravel-5-load-seed-data-from-json/
        	**/
	         DB::table('tags')->insert([
		        'name' => $obj->name
	    	]);
   		 }
    }
}
