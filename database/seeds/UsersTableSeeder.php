<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        User::create([
            'name' => 'Jose Luis',
            'email' => 'joseluisng17@gmail.com',
            'password' => bcrypt('123456'), 
            'dni' => '12345678',
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Paciente test',
            'email' => 'pacientetest@gmail.com',
            'password' => bcrypt('123456'), 
            'dni' => '12334455',
            'role' => 'patient'
        ]);

        User::create([
            'name' => 'Médico test',
            'email' => 'medicotest@gmail.com',
            'password' => bcrypt('123456'), 
            'dni' => '88223344',
            'role' => 'doctor'
        ]);

        factory(User::class, 50)->states('patient')->create();
    }
}
