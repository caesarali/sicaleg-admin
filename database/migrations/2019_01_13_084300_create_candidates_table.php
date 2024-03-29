<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('number')->unsigned()->nullable();
            $table->enum('level', ['dpr', 'dprd'])->nullable();
            $table->string('dapil')->nullable();
            $table->nullableMorphs('locationable');
            $table->integer('picture_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('picture_id')->references('id')->on('pictures')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidates');
    }
}
