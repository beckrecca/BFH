<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hikes', function (Blueprint $table) {

            # ID is primary key, auto-incrementing
            $table->increments('id');
            $table->string('name');
            # Path name for routing
            $table->string('path_name');
            # level of difficulty
            $table->string('climb');
            $table->text('description');
            # URL
            $table->string('web');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hikes');
    }
}
