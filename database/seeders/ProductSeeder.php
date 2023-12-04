<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($j = 0; $j < 10; $j++) {
            $dummyProducts = [];

            for ($i = 0; $i < 1000000; $i++) {
                $dummyProducts[$i]['category_id'] = rand(1, 1000) * 1000;
                $dummyProducts[$i]['name'] = fake()->words(rand(1, 5), true);
                $dummyProducts[$i]['price'] = rand(112, 1000000);
            }


            $chunk_data = array_chunk($dummyProducts, 20000);
            foreach ($chunk_data as $chunk_data_val) {
                DB::table('products')->insert($chunk_data_val);
            }
        }
    }
}
