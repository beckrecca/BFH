<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHikeTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hike_tag', function (Blueprint $table) {
            # ID is primary key, auto-incrementing
            $table->increments('id');
            # `hike_id` and `tag_id` are foreign keys for the hikes and tags tables
            $table->integer('hike_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            # create associations between the two tables
            $table->foreign('hike_id')->references('id')->on('hikes');
            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hike_tag');
    }
}
