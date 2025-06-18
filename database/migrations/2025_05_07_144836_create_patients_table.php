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
            $table->string('cpf');
            $table->string('mother_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('legal_guardian')->nullable();
            $table->date('birth_date');
            $table->integer('age');
            $table->enum('gender', ['Masculino', 'Feminino', 'Homem Cisgênero', 'Mulher Cisgênero', 'Homem Transgênero', 'Mulher Transgênero', 'Pessoa Não Binária', 'Prefere não informar', 'Outro']);
            $table->enum('marital_status', ['Casado', 'Solteiro', 'Divorciado', 'Viúvo']); //estado civil
            $table->integer('children')->default(0);
            $table->string('address');
            $table->string('city');
            $table->string('phone');
            $table->string('emergency_phone_1')->nullable();
            $table->string('emergency_contact_1')->nullable();
            $table->string('emergency_phone_2')->nullable();
            $table->string('emergency_contact_2')->nullable();
            $table->string('religion')->nullable();
            $table->enum('education_level', ['Ensino Fundamental', 'Ensino Médio', 'Ensino Superior', 'Pós-Graduação', 'Mestrado', 'Doutorado']);
            $table->string('occupation');
            $table->json('vices')->nullable(); //vicios
            $table->boolean('family_suicide_history')->default(false); //histórico de suicídio na família
            $table->boolean('suicidal_ideation')->default(false); //pensamentos suicidas
            $table->json('disorders')->nullable(); //disorder
            $table->date('completion_date')->nullable();
            $table->text('completion_notes')->nullable();
            $table->text('family_mental_health_history')->nullable();
            $table->text('family_significant_events')->nullable();
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
