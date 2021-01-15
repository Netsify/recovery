<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSdoSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sdo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 30)->unique();
            $table->string('value', 255);
        });

        \Illuminate\Support\Facades\DB::table('sdo_settings')->insert([
            'key'   => "proctoring_treshold_score",
            'value' => "70"
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sdo_settings');
    }
}
