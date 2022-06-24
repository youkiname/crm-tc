<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->count(1)->create();
        User::create([
            'first_name' => "Vadim",
            'last_name' => "Voronov",
            'email' => "vadimv0810@gmail.com",
            'gender' => "male",
            'phone' => "+79998887766",
            'birth_date' => "1999-08-22",
            'password' => '123123123',
            'role_id' => 1,
        ]);
    }
}
