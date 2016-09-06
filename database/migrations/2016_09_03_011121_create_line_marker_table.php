<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineMarkerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_marker', function (Blueprint $table) {
            # ID is primary key, auto-incrementing
            $table->increments('id');

            # `marker_id` and `line_id` are foreign keys for the lines and markers tables
            $table->integer('marker_id')->unsigned();
            $table->integer('line_id')->unsigned();

            # create the associations between the two tables
            $table->foreign('marker_id')->references('id')->on('markers');
            $table->foreign('line_id')->references('id')->on('lines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('line_marker');
    }
}
