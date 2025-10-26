<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            // Existing seeders
            TestUserSeeder::class,
            GoogleConsoleSeeder::class,
            
            // Sipintar migration seeders
            AdminsSeeder::class,
            MenuMakananSeeder::class,
            UsersSeeder::class,
            FavoritesSeeder::class,
            HistorySeeder::class,
            DeleteAccountRequestsSeeder::class,
        ]);
    }
}
