<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admin_models')->insert([
            'name' => 'Nagaraj',
            'gender' => 1,
            'email' => 'nagaraj@gmail.com',
            'password' => Hash::make('12345678'),
            'mobile' => '1234567890',
            'city' => 'Veerai',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
