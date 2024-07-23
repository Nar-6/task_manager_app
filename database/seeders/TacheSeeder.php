<?php

namespace Database\Seeders;

use App\Models\Tache;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TacheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Assurez-vous d'avoir des utilisateurs dans votre table users
        $users = User::all();

        // Créez des tâches
        for ($i = 0; $i < 20; $i++) {
            Tache::create([
                'nom_tache' => $faker->sentence(3),
                'description' => $faker->paragraph,
                'assigne_a' => $users->random()->email, // Assigne à un utilisateur aléatoire
                'priorite' => $faker->randomElement(['High', 'Medium', 'Low']),
                'statut' => $faker->randomElement(['À faire', 'En cours', 'Terminé']),
            ]);
        }
    }
}
