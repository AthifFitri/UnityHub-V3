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
        Schema::create('evaluation_document', function (Blueprint $table) {
            $table->id('evaDocId');
            $table->unsignedBigInteger('stuId');
            $table->unsignedBigInteger('evaCriId');
            $table->float('docScore')->nullable();
            $table->timestamps();

            $table->foreign('stuId')->references('stuId')->on('student')->onDelete('cascade');
            $table->foreign('evaCriId')->references('evaCriId')->on('evaluation_criteria')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_document');
    }
};
