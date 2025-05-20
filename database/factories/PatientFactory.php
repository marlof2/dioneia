<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {

        return [
            'name' => $this->faker->name(),
            'birth_date' => $this->faker->date('Y-m-d'),
            'age' => $this->faker->numberBetween(18, 80),
            'gender' => $this->faker->randomElement(['Masculino', 'Feminino', 'Homem Cisgênero', 'Mulher Cisgênero', 'Homem Transgênero', 'Mulher Transgênero', 'Pessoa Não Binária', 'Prefere não informar', 'Outro']),
            'marital_status' => $this->faker->randomElement(['Casado', 'Solteiro', 'Divorciado', 'Viúvo']),
            'children' => $this->faker->numberBetween(0, 5),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'phone' => '71991717209',
            'emergency_phone_1' => '71991717209',
            'emergency_contact_1' => 'João da Silva',
            'emergency_phone_2' => '71991717209',
            'emergency_contact_2' => 'Maria da Silva',
            'religion' => $this->faker->randomElement(['Católico', 'Evangélico', 'Espírita', 'Ateu', 'Outro']),
            'education_level' => $this->faker->randomElement([
                'Ensino Fundamental',
                'Ensino Médio',
                'Ensino Superior',
                'Pós-Graduação',
                'Mestrado',
                'Doutorado'
            ]),
            'occupation' => $this->faker->jobTitle(),
            'vices' => $this->faker->optional(0.3)->randomElements([
                'Tabagismo',
                'Alcoolismo',
                'Drogas ilícitas',
                'Jogos de azar'
            ], $this->faker->numberBetween(0, 3)),
            'family_suicide_history' => $this->faker->boolean(20),
            'suicidal_thoughts' => $this->faker->boolean(15),
            'disorders' => $this->faker->optional(0.4)->randomElements([
                'Depressão',
                'Ansiedade',
                'Transtorno Bipolar',
                'Transtorno de Personalidade',
                'Transtorno Obsessivo-Compulsivo',
                'Transtorno de Estresse Pós-Traumático'
            ], $this->faker->numberBetween(0, 3)),
        ];
    }
}
