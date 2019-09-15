<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpotlightsNominationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spotlights_nominations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('spots_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('beatmap_id');
            $table->bigInteger('score')->default(0);
            $table->string('beatmap_artist');
            $table->string('beatmap_title');
            $table->string('beatmap_creator');
            $table->timestamps();

            $table->foreign('spots_id')
                ->references('id')
                ->on('spotlights');
                
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spotlights_nominations');
    }
}
