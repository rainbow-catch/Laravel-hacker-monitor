<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory()->create([
             'name' => 'Admin',
             'email' => 'admin@outlook.com',
             'password' => Hash::make('43wqD2@sl1'),
             'password1' => '43wqD2@sl1',
             'approve' => '2'
         ]);
    }
}
