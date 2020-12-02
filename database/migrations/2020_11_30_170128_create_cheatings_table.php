<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheatings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('image')->nullable();
            $table->longText('content')->nullable();
            $table->bigInteger('info_type_id')->unsigned()->nullable();
            $table->integer('level')->nullable();
            $table->timestamp('uploaded_at')->nullable();
            $table->bigInteger('cheating_type_id')->unsigned()->nullable();
            $table->bigInteger('proctoring_result_id')->unsigned();
//            $table->timestamps();
            $table->foreign('proctoring_result_id')->references('id')->on('proctoring_results');
            $table->foreign('cheating_type_id')->references('id')->on('cheating_types');
            $table->foreign('info_type_id')->references('id')->on('info_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cheatings');
    }
}
