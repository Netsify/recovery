<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProctoringResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proctoring_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tests_result_id');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->integer('score')->nullable();
            $table->timestamp('stream_uploaded')->nullable();
            $table->text('stream_link')->nullable();
//            $table->timestamps();
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
        Schema::dropIfExists('proctoring_results');
    }
}
