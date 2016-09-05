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
        	// Get the marker of this row
            $marker_id = $obj->marker_id;
            $marker = \App\Marker::find($marker_id);
            // Get the line
            $line_id = $obj->line_id;
            $line = \App\Line::find($line_id);
            // Connect this marker to this line
            $marker->lines()->save($marker);
   		 }
    }
}
