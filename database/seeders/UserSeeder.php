<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

/**
 * UserSeeder
 *
 * Seeds the database with predefined user accounts with Spanish names.
 * Creates 30 user records with predictable email addresses and passwords
 * for testing and development purposes.
 *
 * @note Consider using updateOrCreate() instead of create() to avoid
 * duplicate entries if this seeder is run multiple times.
 */
class UserSeeder extends Seeder
{
    /**
     * Seed the users table with predefined Spanish names.
     *
     * For each name in the array, creates a user with:
     * - Name: The Spanish name as provided
     * - Email: Lowercase version of name + @mail.com
     * - Password: The name + "12345678" (hashed)
     *
     * @return void
     */
    public function run()
    {
        // Array of Spanish names (original + new ones)
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
            'Lucía',
            'Antonio',
            'Javier',
            'Fernando',
            'Alejandro',
            'Isabel',
            'Elena',
            'Pilar',
            'Mayte',
            'Pedro',
            'Teresa',
            'Pablo',
            'Diego',
            'Raquel',
            'Alberto',
            'Cristina',
            'Raúl',
            'Laura',
            'Silvia',
            'Manuel',
            'Dolores'
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
