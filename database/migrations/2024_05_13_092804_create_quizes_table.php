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
            $table->enum('course', ['CSM4908', 'CSM4928']);
            $table->unsignedBigInteger('stuId');
            $table->float('score');
            $table->timestamps();

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
