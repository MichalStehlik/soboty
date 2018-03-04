<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstname' => "Administrativní",
            'lastname' => "Administrátor",
            'birthdate' => "1977-02-13",
            'gender' => "male",
            'email' => 'admin@pslib.cz',
            'password' => bcrypt('beruska'),
            'role' => "administrator",
            'email_confirmed' => 1,
        ]);
    }
}
