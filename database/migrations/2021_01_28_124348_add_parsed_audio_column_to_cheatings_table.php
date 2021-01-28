<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParsedAudioColumnToCheatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cheatings', function (Blueprint $table) {
            $table->boolean('is_parsed_audio')->nullable()->after('level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cheatings', function (Blueprint $table) {
            $table->dropColumn('is_parsed_audio');
        });
    }
}
