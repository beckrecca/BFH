<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('markers', function (Blueprint $table) {

            # ID is primary key, auto-incrementing
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->double('lat');
            $table->double('lng');
            $table->float('distance_to_mbta');
            # foreign key field to connect markers to hikes
            $table->integer('hike_id')->unsigned();

            # this field `hike_id` is a foreign key that connects to the `id` field in the `hikes` table
            $table->foreign('hike_id')->references('id')->on('hikes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('markers', function (Blueprint $table) {

            # drop the association between hikes and markers
            $table->dropForeign('markers_hike_id_foreign');
        });

        # then the table can be dropped
        Schema::drop('markers');
    }
}
