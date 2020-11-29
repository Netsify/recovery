<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheatingCodeToKvTestsResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kv_tests_results', function (Blueprint $table) {
            $table->string('cheating_code', 255)->nullable()->index('cheating_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kv_tests_results', function (Blueprint $table) {
            $table->dropColumn('cheating_code');
        });
    }
}
