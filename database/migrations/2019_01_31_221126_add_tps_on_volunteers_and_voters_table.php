<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTpsOnVolunteersAndVotersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('volunteers', function (Blueprint $table) {
        //     $table->integer('voting_place_id')->unsigned()->nullable()->after('locationable_id');
        //     $table->foreign('voting_place_id')->references('id')->on('voting_places')->onDelete('cascade');
        // });

        // Schema::table('voters', function (Blueprint $table) {
        //     $table->integer('voting_place_id')->unsigned()->nullable()->after('locationable_id');
        //     $table->foreign('voting_place_id')->references('id')->on('voting_places')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('volunteers', function (Blueprint $table) {
            //
        });
    }
}
