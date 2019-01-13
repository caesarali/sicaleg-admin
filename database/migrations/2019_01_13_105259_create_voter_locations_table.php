<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoterLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voter_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('voter_id')->unsigned();
            $table->integer('city_id')->unsigned()->nullable();
            $table->integer('district_id')->unsigned()->nullable();
            $table->bigInteger('village_id')->unsigned()->nullable();
            $table->integer('voting_place_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('voter_id')->references('id')->on('voters')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->foreign('village_id')->references('id')->on('villages')->onDelete('cascade');
            $table->foreign('voting_place_id')->references('id')->on('voting_places')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voter_locations');
    }
}
