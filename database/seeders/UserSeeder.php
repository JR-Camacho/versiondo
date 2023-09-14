<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "Jose Camacho",
            "email" => "josecamachoc0303@gmail.com",
            "password" => Hash::make("12345678")
        ]);

        User::create([
            "name" => "Version DO",
            "email" => "versiondo@gmail.com",
            "password" => Hash::make("12345678")
        ]);
    }
}
