<?php

namespace Database\Seeders;

use App\Models\User;
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
            'first_name' => 'Delma',
            'last_name' => 'Shajan',
            'email' => 'delmashajan@gmail.com',
            'password' => bcrypt('delma@123'),
        ]);
    }
}
