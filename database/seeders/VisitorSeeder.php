<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Visitor;

class VisitorSeeder extends Seeder
{
    public function run()
    {
        Visitor::factory()->count(200)->create();
    }
}
