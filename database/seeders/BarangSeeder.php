<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $laptop = Category::where('name','laptop')->first();
        
        Barang::create([
            'category_id' => $laptop->id,
            'name' => 'asus fan services',
            'stock' => 5,
        ]);

        Barang::create([
            'category_id' => $laptop->id,
            'name' => 'macbook',
            'stock' => 2,
        ]);

        $mouse = Category::where('name','mouse')->first();
        
        Barang::create([
            'category_id' => $mouse->id,
            'name' => 'mouse wireless',
            'stock' => 10,
        ]);
        
        Barang::create([
            'category_id' => $mouse->id,
            'name' => 'mouse nirkabel',
            'stock' => 15,
        ]);
        
        $keyboard = Category::where('name','keyboard')->first();
        
        Barang::create([
            'category_id' => $keyboard->id,
            'name' => 'keyboard wireless',
            'stock' => 5,
        ]);

        Barang::create([
            'category_id' => $keyboard->id,
            'name' => 'keyboard nirkabel',
            'stock' => 10,
        ]);

        $headset = Category::where('name','headset')->first();

        Barang::create([
            'category_id' => $headset->id,
            'name' => 'rexus',
            'stock' => 10,
        ]);
        
        Barang::create([
            'category_id' => $headset->id,
            'name' => 'zyrex',
            'stock' => 8,
        ]);
        
    }
}
