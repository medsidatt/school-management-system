<?php

namespace Database\Seeders;

use App\Models\StudentParent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudentParent::factory()->count(60)->create();
    }
}
