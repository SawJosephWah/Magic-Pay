<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        // $this->call(UserSeeder::class);
        DB::table('admins')->insert([
            'name' => 'Admin Demo',
            'email' =>'adminDemo@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '0999999999'
        ]);

    }
}
