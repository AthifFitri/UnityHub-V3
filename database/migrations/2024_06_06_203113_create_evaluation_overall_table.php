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
        Schema::create('evaluation_overall', function (Blueprint $table) {
            $table->id('evaOverallId');
            $table->enum('assessorType', ['University', 'Industry']);
            $table->unsignedBigInteger('stuId');
            $table->unsignedBigInteger('assessmentId');
            $table->unsignedBigInteger('assessmentId');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_overall');
    }
};
