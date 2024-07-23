<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create additional non-admin users
        for ($i = 0; $i < 12; $i++) {
            User::create([
                'nom' => $faker->lastName,
                'prenom' => $faker->firstName,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'), // Changez ce mot de passe pour quelque chose de plus sécurisé
                'role' => 'Utilisateur', // Non-admin role
            ]);
        }
    }
}
