<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quizes', function (Blueprint $table) {
            $table->id('quizId');
            $table->unsignedBigInteger('courseId');
            $table->unsignedBigInteger('stuId');
            $table->float('score');
            $table->timestamps();

            $table->foreign('courseId')->references('courseId')->on('courses')->onDelete('cascade');
            $table->foreign('stuId')->references('stuId')->on('student')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizes');
    }
};
