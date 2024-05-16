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
        Schema::create('documents', function (Blueprint $table) {
            $table->id('docId');
            $table->unsignedBigInteger('stuId');
            $table->string('docType');
            $table->string('docTitle');
            $table->binary('docContent');
            $table->datetime('deadline');
            $table->timestamps();

            $table->foreign('stuId')->references('stuId')->on('student')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
