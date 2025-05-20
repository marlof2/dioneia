<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        // Criar 50 pacientes de teste
        Patient::factory()->count(20)->create();
    }
}
