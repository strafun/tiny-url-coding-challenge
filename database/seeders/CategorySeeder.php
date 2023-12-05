<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dummyCategories = [];
        $i = 0;
        do {
            $title = fake()->words(3, true);
            if (!in_array($title, $dummyCategories)) {
                $dummyCategories[$i]['title'] = $title;
                $i++;
            }
        } while ($i < 1000);

        sort($dummyCategories);

        for ($i = 0; $i < 1000; $i++) {
            $dummyCategories[$i]['id'] = ($i+1) * 1000;
        }

        DB::table('categories')->insert($dummyCategories);
    }
}
