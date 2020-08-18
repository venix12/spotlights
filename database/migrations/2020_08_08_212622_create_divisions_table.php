<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('season_id')->unsigned();
            $table->string('name');
            $table->double('threshold', 8, 3);
            $table->boolean('absolute')->default(0);
            $table->timestamps();

            $table->foreign('season_id')
                ->references('id')
                ->on('seasons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('divisions');
    }
}
