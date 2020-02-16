<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('app_id')->unsigned();
            $table->bigInteger('question_id')->unsigned();
            $table->string('answer', 3000);
            $table->timestamps();

            $table->foreign('app_id')
                ->references('id')
                ->on('applications');

            $table->foreign('question_id')
                ->references('id')
                ->on('app_questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_answers');
    }
}
