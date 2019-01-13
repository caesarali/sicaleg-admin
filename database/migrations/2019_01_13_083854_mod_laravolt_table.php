<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModLaravoltTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropForeign(['province_id']);
        });
        Schema::table('districts', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
        });
        Schema::table('villages', function (Blueprint $table) {
            $table->dropForeign(['district_id']);
        });

        Schema::table('provinces', function (Blueprint $table) {
            $table->increments('id')->change();
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->increments('id')->change();
            $table->integer('province_id')->unsigned()->change();
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
        });

        Schema::table('districts', function (Blueprint $table) {
            $table->increments('id')->change();
            $table->integer('city_id')->unsigned()->change();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });

        Schema::table('villages', function (Blueprint $table) {
            $table->bigIncrements('id')->change();
            $table->integer('district_id')->unsigned()->change();
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
