<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        $birthDate = $this->faker->dateTimeBetween('-80 years', '-18 years');

        return [
            'name' => $this->faker->name(),
            'birth_date' => $birthDate,
            'age' => $this->faker->numberBetween(18, 80),
            'gender' => $this->faker->randomElement(['masculino', 'feminino']),
            'marital_status' => $this->faker->randomElement(['casado', 'solteiro', 'divorciado', 'viuvo']),
            'children' => $this->faker->numberBetween(0, 5),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'phone' => '71991717209',
            'religion' => $this->faker->randomElement(['Católico', 'Evangélico', 'Espírita', 'Ateu', 'Outro']),
            'education_level' => $this->faker->randomElement([
                'Ensino Fundamental Incompleto',
                'Ensino Fundamental Completo',
                'Ensino Médio Incompleto',
                'Ensino Médio Completo',
                'Ensino Superior Incompleto',
                'Ensino Superior Completo',
                'Pós-graduação'
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
