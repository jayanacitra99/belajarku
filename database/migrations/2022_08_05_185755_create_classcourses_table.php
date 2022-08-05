<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classcourses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('classID')->nullable();
            $table->foreign('classID')->references('id')->on('classes')->cascadeOnUpdate()->nullOnDelete();
            $table->unsignedInteger('courseID')->nullable();
            $table->foreign('courseID')->references('id_course')->on('courses')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classcourses');
    }
};
