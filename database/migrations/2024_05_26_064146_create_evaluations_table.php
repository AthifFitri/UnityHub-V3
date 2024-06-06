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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id('evaId');
            $table->enum('assessor', ['University', 'Industry']);
            $table->unsignedBigInteger('courseId');
            $table->unsignedBigInteger('assessmentId');
            $table->integer('plo');
            $table->timestamps();

            $table->foreign('courseId')->references('courseId')->on('courses')->onDelete('cascade');
            $table->foreign('assessId')->references('assessId')->on('assessments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
