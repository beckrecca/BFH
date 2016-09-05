<?php

use Illuminate\Database\Seeder;

class LinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve JSON file of MBTA lines
        $json = File::get("database/data/lines.json");
        // Decode the JSON data
        $data = json_decode($json); 
        // for each line, insert into table
        foreach ($data as $obj) {
        	/**
        	* Adapted from Sam Deering's article
        	* http://www.fullstack4u.com/laravel/laravel-5-load-seed-data-from-json/
        	**/
	         DB::table('lines')->insert([
		        'name' => $obj->name,
		        'service' => $obj->service
	    	]);
   		 }
    }
}
