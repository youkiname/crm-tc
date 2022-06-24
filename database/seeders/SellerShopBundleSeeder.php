<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Shop;
use App\Models\User;
use App\Models\Role;
use App\Models\SellerShopBundle;

class SellerShopBundleSeeder extends Seeder
{
    public function run()
    {
        $sellerRoleId = Role::where('name', 'seller')->first()->id;
        foreach (User::where('role_id', $sellerRoleId)->get() as $seller) {
            SellerShopBundle::create([
                'seller_id' => $seller->id,
                'shop_id' => Shop::inRandomOrder()->first()->id,
            ]);
        }
    }
}
