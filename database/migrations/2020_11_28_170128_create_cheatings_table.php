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
            $table->string('info')->nullable();
            $table->integer('level')->nullable();
            $table->timestamp('uploaded_at')->nullable();
            $table->string('cheating_type')->nullable();
            $table->bigInteger('proctoring_result_id')->unsigned();
//            $table->timestamps();
            $table->foreign('proctoring_result_id')->references('id')->on('proctoring_results');
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
