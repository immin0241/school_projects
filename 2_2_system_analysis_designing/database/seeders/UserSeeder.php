<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserType;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->createPredefinedUsers();
    }
}
