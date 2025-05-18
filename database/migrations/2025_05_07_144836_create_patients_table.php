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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('birth_date');
            $table->integer('age');
            $table->enum('gender', ['masculino', 'feminino']);
            $table->enum('marital_status', ['casado', 'solteiro', 'divorciado', 'viuvo']); //estado civil
            $table->integer('children')->default(0);
            $table->string('address');
            $table->string('city');
            $table->string('phone');
            $table->string('religion')->nullable();
            $table->string('education_level'); //nivel de escolaridade
            $table->string('occupation');
            $table->json('vices')->nullable(); //vicios
            $table->boolean('family_suicide_history')->default(false); //histórico de suicídio na família
            $table->boolean('suicidal_thoughts')->default(false); //pensamentos suicidas
            $table->json('disorders')->nullable(); //disorder
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
