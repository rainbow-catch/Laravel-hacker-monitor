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
        // Admin User
         \App\Models\User::factory()->create([
             'name' => 'Admin',
             'email' => 'admin@outlook.com',
             'password' => Hash::make('43wqD2@sl1'),
             'password1' => '43wqD2@sl1',
             'approve' => '2'
         ]);
        // Primary User
        \App\Models\User::factory()->create([
            'password' => Hash::make('asdfasdf'),
            'password1' => 'asdfasdf',
            'approve' => '2'
        ]);
        // Guest
        $guest = \App\Models\User::factory()->create([
            'password' => Hash::make('asdfasdf'),
            'password1' => 'asdfasdf',
            'parent_id' => 1,
            'approve' => '3'
        ]);

        // Role
        \App\Models\Role::create([
            'see_home' => true,
            'see_screenshots' => false,
            'see_hack_logs' => false,
            'see_connect_logs' => false,
            'see_tools_download' => false,
            'see_guides' => false,
            'ban_hardware' => false,
            'guest_id' => $guest->id
        ]);
         //Download files
         \App\Models\DownloadFile::create([
             'name' => 'Xor Generator',
             'description' => 'Compact the downloaded license from the License panel.',
             'path' => 'https://www.softwarerg.com/Xor_License_Generator.rar',
             'update_date' => '2023-03-07'
         ]);
         \App\Models\DownloadFile::create([
             'name' => 'Season 1 Original',
             'description' => 'Remember to replace everything that is shipped.',
             'path' => 'https://www.softwarerg.com/S1_XOR.rar',
             'update_date' => '2023-03-14'
         ]);
         \App\Models\DownloadFile::create([
             'name' => 'Season 3 Original',
             'description' => 'Remember to replace everything that is shipped.',
             'path' => 'https://www.softwarerg.com/S3_XOR.rar',
             'update_date' => '2023-03-14'
         ]);
         \App\Models\DownloadFile::create([
             'name' => 'Season 4 Original',
             'description' => 'Remember to replace everything that is shipped.',
             'path' => 'https://www.softwarerg.com/S4_XOR.rar',
             'update_date' => '2023-03-14'
         ]);
         \App\Models\DownloadFile::create([
             'name' => 'Season 6 or Downgrade',
             'description' => 'Remember to replace everything that is shipped.',
             'path' => 'https://www.softwarerg.com/S6_XOR.rar',
             'update_date' => '2023-03-14'
         ]);
         \App\Models\DownloadFile::create([
             'name' => 'Season 8 Original',
             'description' => 'Remember to replace everything that is shipped.1111',
             'path' => 'https://www.softwarerg.com/S8_XOR.rar',
             'update_date' => '2023-03-14'
         ]);
    }
}
