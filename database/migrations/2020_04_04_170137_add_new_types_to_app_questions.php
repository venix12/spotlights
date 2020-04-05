<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewTypesToAppQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_questions', function (Blueprint $table) {
            $table->string('type')->default('textarea')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_questions_types', function (Blueprint $table) {
            $table->enum('type', ['checkbox', 'input', 'textarea'])->default('textarea')->change();
        });
    }
}
