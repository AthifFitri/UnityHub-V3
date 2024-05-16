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
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id('logId');
            $table->unsignedBigInteger('stuId');
            $table->string('week');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('attendance');
            $table->text('daily_activities');
            $table->text('knowledge_skill');
            $table->text('problem_comment');
            $table->enum('status', ['pending', 'approved'])->default('pending');
            $table->timestamps();

            $table->foreign('stuId')->references('stuId')->on('student')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};
