<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nom' => 'NOM_ADMIN',
            'prenom' => 'Prenom_Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'), // Assurez-vous de changer ce mot de passe pour quelque chose de plus sécurisé
            'role' => 'Admin',
        ]);
    }
}
