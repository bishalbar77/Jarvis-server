<?php

use Illuminate\Database\Seeder;
use App\User;
use App\JarvisUser;
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
        // $this->call(UserTableSeeder::class);
        
        $admin = User::create([
            'name' => 'Jarvis User',
            'email' => 'jarvis@gettruehelp.com',
            'email_verified_at' => '2021-08-10 19:00:02',
            'password' => Hash::make('Jarvis@123'),
        ]);
        
        $jarvis = JarvisUser::create([
            'name' => 'Jarvis User',
            'email' => 'jarvis@gettruehelp.com',
            'user_id' => 1,
            'status' => 'A',
            'password' => Hash::make('Jarvis@123'),
        ]);
    }
}
