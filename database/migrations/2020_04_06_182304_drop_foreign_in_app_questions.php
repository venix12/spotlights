<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropForeignInAppQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_questions', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
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
            $table->foreign('parent_id')
                ->references('id')
                ->on('app_questions');
        });
    }
}
