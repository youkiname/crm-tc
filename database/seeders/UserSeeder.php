<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        $customerRoleId = Role::where('name', 'customer')->first()->id;
        $sellerRoleId = Role::where('name', 'seller')->first()->id;
        $renterRoleId = Role::where('name', 'renter')->first()->id;
        $adminRoleId = Role::where('name', 'admin')->first()->id;

        User::factory()->count(50)->create();
        User::factory()->state([
            'role_id' => $sellerRoleId,
        ])->count(200)->create();

        User::create([
            'first_name' => "Customer",
            'last_name' => "Test",
            'email' => "customer@mail.ru",
            'card_number' => '1111111111111111',
            'gender' => "male",
            'phone' => "+79998887766",
            'birth_date' => "1999-08-22",
            'password' => Hash::make('123123123'),
            'role_id' => $customerRoleId,
            'email_verified_at' => now()
        ]);
        User::create([
            'first_name' => "Seller",
            'last_name' => "Test",
            'email' => "seller@mail.ru",
            'card_number' => '1111111111111112',
            'gender' => "male",
            'phone' => "+79998887766",
            'birth_date' => "1999-08-22",
            'password' => Hash::make('123123123'),
            'role_id' => $sellerRoleId,
            'email_verified_at' => now()
        ]);
        User::create([
            'first_name' => "Renter",
            'last_name' => "Test",
            'email' => "renter@mail.ru",
            'card_number' => '1111111111111113',
            'gender' => "male",
            'phone' => "+79998887766",
            'birth_date' => "1999-08-22",
            'password' => Hash::make('123123123'),
            'role_id' => $renterRoleId,
            'email_verified_at' => now()
        ]);
        User::create([
            'first_name' => "Admin",
            'last_name' => "Test",
            'email' => "admin@mail.ru",
            'card_number' => '1111111111111114',
            'gender' => "male",
            'phone' => "+79998887766",
            'birth_date' => "1999-08-22",
            'password' => Hash::make('123123123'),
            'role_id' => $adminRoleId,
            'email_verified_at' => now()
        ]);
        User::create([
            'first_name' => "Lexajтdw",
            'last_name' => "Lexa",
            'email' => "te@te.te",
            'card_number' => '1111111111111115',
            'gender' => "male",
            'phone' => "+798856424367",
            'birth_date' => "1999-08-22",
            'password' => Hash::make('123123123'),
            'role_id' => $customerRoleId,
            'email_verified_at' => now()
        ]);
        User::create([
            'first_name' => "Max",
            'last_name' => "Maximov",
            'email' => "aq@aq.aq",
            'card_number' => '1111111111111116',
            'gender' => "male",
            'phone' => "+798856424367",
            'birth_date' => "1999-08-22",
            'password' => Hash::make('123123123'),
            'role_id' => $customerRoleId,
            'email_verified_at' => now()
        ]);
        User::create([
            'first_name' => "Александр",
            'last_name' => "Курылев",
            'email' => "appdetra@gmail.com",
            'card_number' => '1111111111111117',
            'gender' => "male",
            'phone' => "89176276758",
            'birth_date' => "2003-09-29",
            'password' => Hash::make('123123123'),
            'role_id' => $customerRoleId,
            'email_verified_at' => now()
        ]);
        User::create([
            'first_name' => "илья",
            'last_name' => "илья",
            'email' => "bavaw18343@lockaya.com",
            'card_number' => '1111111111111118',
            'gender' => "male",
            'phone' => "+79888888888",
            'birth_date' => "2022-05-17",
            'password' => Hash::make('123123123'),
            'role_id' => $customerRoleId,
            'email_verified_at' => now()
        ]);
    }
}
