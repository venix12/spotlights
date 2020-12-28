<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaylistEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compose_playlist_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('osu_beatmap_id');
            $table->string('artist');
            $table->string('title');
            $table->string('creator');
            $table->integer('creator_osu_id');
            $table->string('difficulty_name');
            $table->string('mod')->nullable();
            $table->enum('difficulty', ['hard', 'insane', 'expert']);
            $table->timestamp('ranked_at');
            $table->bigInteger('playlist_id')->unsigned();
            $table->timestamps();

            $table->foreign('playlist_id')
                ->references('id')
                ->on('compose_playlists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compose_playlist_entries');
    }
}
