<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ShoppingCenter;
use App\Models\User;
use App\Models\Role;
use App\Models\AdminShoppingCenterBundle;

class AdminShoppingCenterBundleSeeder extends Seeder
{
    public function run()
    {
        $adminRoleId = Role::where('name', 'admin')->first()->id;
        foreach (User::where('role_id', $adminRoleId)->get() as $admin) {
            AdminShoppingCenterBundle::create([
                'admin_id' => $admin->id,
                'shopping_center_id' => ShoppingCenter::inRandomOrder()->first()->id,
            ]);
        }
    }
}
