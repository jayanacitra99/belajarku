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
        Schema::create('forums', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userID')->nullable();
            $table->foreign('userID')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->unsignedInteger('classID')->nullable();
            $table->foreign('classID')->references('id')->on('classes')->cascadeOnUpdate()->nullOnDelete();
            $table->unsignedInteger('courseID')->nullable();
            $table->foreign('courseID')->references('id_course')->on('courses')->cascadeOnUpdate()->nullOnDelete();
            $table->text('chat');
            $table->timestamp('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forums');
    }
};
