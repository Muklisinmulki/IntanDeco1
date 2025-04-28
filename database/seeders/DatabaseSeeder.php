<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);

        $this->call([
            CategoriesTableSeeder::class,
        ]);
    
        // Kemudian seed catalog
        $this->call([
            CatalogSeeder::class,
        ]);
    }
}