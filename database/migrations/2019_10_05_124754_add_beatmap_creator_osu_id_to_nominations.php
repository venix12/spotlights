<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBeatmapCreatorOsuIdToNominations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spotlights_nominations', function (Blueprint $table) {
            $table->bigInteger('beatmap_creator_osu_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spotlights_nominations', function (Blueprint $table) {
            $table->dropColumn('beatmap_creator_osu_id');
        });
    }
}
