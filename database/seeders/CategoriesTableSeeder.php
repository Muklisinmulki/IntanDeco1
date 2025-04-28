<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Coaster',
            'Ashtray',
            'Candle holder',
            'Bowl',
            'Jar',
            'Plate Tray',
            'Soap dish',
            'Vase',
            'Dispenser',
            'Lamp',
            'Cake place / bowl fruit',
            'Bath room set',
            'Tissue box',
            'Home Decoration',
            'Wash basin'
        ];

        foreach ($categories as $category) {
            \App\Models\Category::firstOrCreate([
                'name' => $category
            ]);
        }
    }
}