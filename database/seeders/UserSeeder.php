<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'prueba',
            'email' => 'pruebas@pruebas.test',
            'password' => bcrypt('pruebas.test'),
        ]);
        User::create([
            'name' => 'prueba2',
            'email' => 'pruebas2@pruebas.test',
            'password' => bcrypt('pruebas.test'),
        ]);
    }
}
