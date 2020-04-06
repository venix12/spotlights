<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationFieldsToAppQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_questions', function (Blueprint $table) {
            $table->integer('relation_type')->default(0);
            $table->bigInteger('parent_id')->unsigned()->nullable();

            $table->foreign('parent_id')
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
        Schema::table('app_questions', function (Blueprint $table) {
            //
        });
    }
}
