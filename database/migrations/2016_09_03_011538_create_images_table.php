<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {

            # ID is primary key, auto-incrementing
            $table->increments('id');
            # file name
            $table->string('file');
            # alt caption
            $table->text('alt');
            # title caption
            $table->string('title');
            # foreign key field to connect images to hikes
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
        Schema::table('images', function (Blueprint $table) {

            # drop the association between hikes and images
            $table->dropForeign('images_hike_id_foreign');
        });

        # then the table can be dropped
        Schema::drop('images');
    }
}
