<?php

use Database\Seeders\InfoTypeSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_types', function (Blueprint $table) {
            $table->id();
            $table->string('info_en', 255);
            $table->string('info_ru', 255)->nullable();
            $table->timestamps();
        });

        /**
         * Заполняем таблицу типами
         *
         */
        (new InfoTypeSeeder())->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('info_types');
    }
}
