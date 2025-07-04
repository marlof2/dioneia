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
        Schema::create('promptuary', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->foreignId('patient1_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('patient2_id')->nullable()->constrained('patients')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promptuary');
    }
};
