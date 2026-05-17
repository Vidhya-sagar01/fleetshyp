<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // User model import karna zaroori hai
use Illuminate\Support\Facades\Hash; // Password hash karne ke liye

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com', 
            'password' => Hash::make('123456'), 
            'role' => 'admin',
        ]);
    }
}