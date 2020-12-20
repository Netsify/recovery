<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProctoringIdentificationPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proctoring_identification_photos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pk')->comment('ID из запрос на смену фото от Aero');
            $table->integer('student_id');
            $table->string('old_image', 255);
            $table->string('new_image', 255);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proctoring_identification_photos');
    }
}
