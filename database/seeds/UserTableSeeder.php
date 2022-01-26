<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Jarvis User',
            'email' => 'jarvis@gettruehelp.com',
            'email_verified_at' => '2021-08-10 19:00:02',
            'password' => Hash::make('Jarvis@123'),
        ]);
    }
}
