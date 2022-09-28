<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Matías Benítez',
            'email' => 'matias@correo.com',
            'password' => bcrypt('password')
        ]);
    }
}
