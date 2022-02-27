<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComposePlaylistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compose_playlists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('mode', ['osu', 'mania', 'catch', 'taiko']);
            $table->string('name');
            $table->bigInteger('season_id')->unsigned();
            $table->timestamps();

            $table->foreign('season_id')
                ->references('id')
                ->on('compose_seasons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compose_playlists');
    }
}
