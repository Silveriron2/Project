<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'yu8gyuyig97yu',
            'email' => 'kakaka@gmail.com',
            'contact_number' => '09945364846',
            'otp_code' => '123456',
            'password' => Hash::make('12345678')
        ]);
    }
}
