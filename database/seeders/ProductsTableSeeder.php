<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use DateTime;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultImagePath = 'images/default.jpg';
        $imgPath = Storage::exists($defaultImagePath)?
                   Storage::get($defaultImagePath):null;

        DB::table('products')->insert([
            'company_id' => 1,
            'product_name' => 'Product',
            'price' => 100,
            'stock' => 100,
            'comment' => 'Comment',
            'img_path' => $imgPath,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}