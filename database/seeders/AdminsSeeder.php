<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'id' => 'ae94e84e-0dab-4ae9-b378-c232117c4e12',
                'name' => 'Admin Baru',
                'email' => '2103015207@uhamka.ac.id',
                'username' => 'admin',
                'is_super' => true,
                'created_at' => '2025-08-07 08:43:17',
                'updated_at' => '2025-08-07 08:43:17',
            ],
            [
                'id' => 'fa3a8d22-b1e5-40fe-b654-ab6f522a5083',
                'name' => 'alfino',
                'email' => 'westonwiliam29@gmail.com',
                'username' => 'alfino',
                'is_super' => false,
                'created_at' => '2025-08-27 20:36:19',
                'updated_at' => '2025-08-31 18:26:22',
            ],
        ];

        foreach ($admins as $admin) {
            \DB::table('admins')->insert($admin);
        }
    }
}
