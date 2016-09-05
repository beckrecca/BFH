<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Call the hikes seeder
        $this->call(HikesTableSeeder::class);
        // Call the markers seeder
        $this->call(MarkersTableSeeder::class);
        // Call the lines seeder
        $this->call(LinesTableSeeder::class);
    }
}
