<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Category::create([
            'name' => 'laptop'
        ]);
        Category::create([
            'name' => 'mouse'
        ]);
        Category::create([
            'name' => 'keyboard'
        ]);
        Category::create([
            'name' => 'headset'
        ]);
    }
}
