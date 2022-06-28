<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->count(50)->create();
        $customerRoleId = Role::where('name', 'customer')->first()->id;
        $sellerRoleId = Role::where('name', 'seller')->first()->id;
        $renterRoleId = Role::where('name', 'renter')->first()->id;
        $adminRoleId = Role::where('name', 'admin')->first()->id;

        User::create([
            'first_name' => "Customer",
            'last_name' => "Test",
            'email' => "customer@mail.ru",
            'card_number' => '1111111111111111',
            'gender' => "male",
            'phone' => "+79998887766",
            'birth_date' => "1999-08-22",
            'password' => '123123123',
            'role_id' => $customerRoleId,
        ]);
        User::create([
            'first_name' => "Seller",
            'last_name' => "Test",
            'email' => "seller@mail.ru",
            'card_number' => '1111111111111112',
            'gender' => "male",
            'phone' => "+79998887766",
            'birth_date' => "1999-08-22",
            'password' => '123123123',
            'role_id' => $sellerRoleId,
        ]);
        User::create([
            'first_name' => "Renter",
            'last_name' => "Test",
            'email' => "renter@mail.ru",
            'card_number' => '1111111111111113',
            'gender' => "male",
            'phone' => "+79998887766",
            'birth_date' => "1999-08-22",
            'password' => '123123123',
            'role_id' => $renterRoleId,
        ]);
        User::create([
            'first_name' => "Admin",
            'last_name' => "Test",
            'email' => "admin@mail.ru",
            'card_number' => '1111111111111114',
            'gender' => "male",
            'phone' => "+79998887766",
            'birth_date' => "1999-08-22",
            'password' => '123123123',
            'role_id' => $adminRoleId,
        ]);
    }
}
