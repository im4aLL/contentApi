<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(['name' => 'Habib Hadi', 'email' => 'hadicse@gmail.com', 'password' => bcrypt('123456')]);
    }
}
