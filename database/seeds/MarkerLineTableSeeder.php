<?php

use Illuminate\Database\Seeder;

class MarkerLineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve JSON file of paired marker and line IDs
        $json = File::get("database/data/marker_line.json");
        // Decode the JSON data
        $data = json_decode($json); 
        // for each marker line pair, insert into table
        foreach ($data as $obj) {
        	/**
            * Adapted from Sam Deering's article
            * http://www.fullstack4u.com/laravel/laravel-5-load-seed-data-from-json/
            **/
             DB::table('marker_line')->insert([
                'marker_id' => $obj->marker_id,
                'line_id' => $obj->line_id
            ]);
   		 }
    }
}
