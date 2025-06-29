<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory(24)->create();

        // User::firstOrCreate([
        //     'name' => 'Marlo',
        //     'email' => 'marlosilva.f2@gmail.com',
        //     'password' => bcrypt('123'),
        // ]);

        User::firstOrCreate([
            'name' => 'Dioneia',
            'email' => 'dioneia@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        $this->call([
            // PatientSeeder::class,
        ]);
    }
}
