<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kk')->nullable();
            $table->string('nik', 16)->nullable();
            $table->string('name');
            $table->string('birth_place', 30)->nullable();
            $table->date('birth_date')->nullable();
            $table->char('marital_status', 1)->nullable();
            $table->char('gender', 1)->nullable();
            $table->string('addr_street')->nullable();
            $table->string('addr_rt')->nullable();
            $table->string('addr_rw')->nullable();
            $table->string('information')->nullable();
            $table->integer('disability_id')->unsigned()->nullable();
            $table->integer('marital_status_id')->unsigned()->nullable();
            $table->nullableMorphs('locationable');
            $table->integer('voting_place_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('voting_place_id')->references('id')->on('voting_places')->onDelete('cascade');
            $table->foreign('disability_id')->references('id')->on('ref_disabilities')->onDelete('cascade');
            $table->foreign('marital_status_id')->references('id')->on('ref_marital_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voters');
    }
}
