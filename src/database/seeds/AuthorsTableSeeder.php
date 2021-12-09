<?php

use App\Author;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Author::create([
            'email' => 'mrahn1234@gmail.com',
            'username' => 'mrahn1234',
            'fullname' => 'Hoang Tu Le',
            'password' => Hash::make('123456'),
            'avatar' => '',
            'address' => 'Trung Nu Vuong',
            'birthday' => '1998-01-07',
            'phone' => '0774444770',
        ]);

        Author::create([
            'email' => 'admin@gmail.com',
            'username' => 'adminn',
            'fullname' => 'Admin ne',
            'password' => Hash::make('123456'),
            'avatar' => '',
            'address' => 'Le Cao Lang',
            'birthday' => '1998-01-07',
            'phone' => '0774444779',
        ]);
    }
}
