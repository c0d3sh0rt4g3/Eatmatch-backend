<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Array of Spanish names
        $users = [
            'Carlos',
            'María',
            'José',
            'Ana',
            'Luis',
            'Carmen',
            'Jorge',
            'Sofía',
            'Miguel',
            'Lucía'
        ];

        foreach ($users as $name) {
            User::create([
                'name'     => $name,
                'email'    => strtolower($name) . '@mail.com', // Email based on the name
                'password' => bcrypt($name . '12345678'),      // Password based on the name
            ]);
        }
    }
}
