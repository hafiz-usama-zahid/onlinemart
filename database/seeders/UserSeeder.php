<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            User::create([
        'name' => 'AdminUser',
        'email' => 'admin@store.com',
        'password' => hash('password'),
        'user_type' => 'admin'
]);

    }
}
