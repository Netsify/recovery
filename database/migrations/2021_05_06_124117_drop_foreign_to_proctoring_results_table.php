<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropForeignToProctoringResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proctoring_results', function (Blueprint $table) {
            $table->dropForeign('proctoring_results_tests_result_id_foreign');
            $table->foreign('tests_result_id')->references('id')->on('kv_tests_results');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proctoring_results', function (Blueprint $table) {
            //
        });
    }
}
