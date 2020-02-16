<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('cycle_id')->unsigned();
            $table->bigInteger('feedback_author_id')->nullable()->unsigned();
            $table->boolean('approved')->default(0);
            $table->enum('gamemode', ['osu', 'taiko', 'mania', 'catch']);
            $table->enum('verdict', ['fail', 'pass'])->nullable();
            $table->string('feedback', 3000)->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('cycle_id')
                ->references('id')
                ->on('app_cycles');

            $table->foreign('feedback_author_id')
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
        Schema::dropIfExists('applications');
    }
}
