<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpotlightsNominationVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spotlights_nomination_votes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('spots_id')->unsigned();
            $table->bigInteger('nomination_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->integer('value'); //-1, 0, 1
            $table->string('comment')->nullable();
            $table->timestamps();

            $table->foreign('spots_id')
                ->references('id')
                ->on('spotlights');

            $table->foreign('nomination_id')
                ->references('id')
                ->on('spotlights_nominations');

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
        Schema::dropIfExists('spotlights_nomination_votes');
    }
}
