<?php

use Database\Seeders\CheatingTypeSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheatingTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheating_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('description_en', 255);
            $table->string('description_ru', 255)->nullable();
            $table->timestamps();
        });

        /**
         * Заполняем таблицу типами
         *
         */
        (new CheatingTypeSeeder())->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cheating_types');
    }
}
