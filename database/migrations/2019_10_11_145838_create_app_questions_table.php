<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('question');
            $table->bigInteger('char_limit')->default(1000);
            $table->boolean('active')->default(1);
            $table->boolean('required')->default(0);
            $table->enum('type', ['checkbox', 'input', 'textarea'])->default('textarea');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_questions');
    }
}
