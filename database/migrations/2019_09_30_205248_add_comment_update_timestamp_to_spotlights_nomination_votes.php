<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentUpdateTimestampToSpotlightsNominationVotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spotlights_nomination_votes', function (Blueprint $table) {
            $table->timestamp('comment_updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spotlights_nomination_votes', function (Blueprint $table) {
            $table->dropColumn('comment_updated_at');
        });
    }
}
