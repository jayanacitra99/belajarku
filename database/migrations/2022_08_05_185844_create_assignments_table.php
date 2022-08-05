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
        Schema::create('assignments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('classID')->nullable();
            $table->foreign('classID')->references('id')->on('classes')->cascadeOnUpdate()->nullOnDelete();
            $table->unsignedInteger('courseID')->nullable();
            $table->foreign('courseID')->references('id_course')->on('courses')->cascadeOnUpdate()->nullOnDelete();
            $table->text('title');
            $table->text('description');
            $table->enum('type',['ASSIGNMENT','QUIZ','MODULE','ESSAY']);
            $table->text('files')->nullable();
            $table->text('link')->nullable();
            $table->text('voice')->nullable();
            $table->text('image')->nullable();
            $table->text('question')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');
    }
};
