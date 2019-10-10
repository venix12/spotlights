<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultToSpotlightModes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spotlights', function (Blueprint $table) {
            $table->boolean('osu')->default(0)->change();
            $table->boolean('taiko')->default(0)->change();
            $table->boolean('catch')->default(0)->change();
            $table->boolean('mania')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spotlights', function (Blueprint $table) {
            $table->boolean('osu')->change();
            $table->boolean('taiko')->change();
            $table->boolean('catch')->change();
            $table->boolean('mania')->change();
        });
    }
}
