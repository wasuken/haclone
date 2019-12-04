<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => Str::random(20),
            'email' => Str::random(10) . '@' . Str::random(5) . '.' . 'jp',
            'password' => Hash::make(Str::random(10))
        ]);
        DB::table('users')->insert([
            'name' => 'unchi',
            'email' => 'unchi@test.com',
            'password' => Hash::make('unchiunchi')
        ]);
    }
}
