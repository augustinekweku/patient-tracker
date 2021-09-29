<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'user_type' => 'admin',
            'phone' => '+233 241801505',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
