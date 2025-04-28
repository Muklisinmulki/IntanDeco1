<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Kosongkan tabel dulu
        DB::table('catalogs')->truncate();
        
        $catalogs = [
            [
                'name' => 'Marble | Gray, Black | 10x10x1 cm 280 gr',
                'code' => 'C06',
                'category_id' => 1,
                'image' => 'Produk/produk-1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => ' Marble | Cream, Gray, Black D 19x3,5 cm | 1.650 gr',
                'code' => 'A04',
                'category_id' => 2,
                'image' => 'Produk/produk-2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => ' Marble+teak wood | Cream D12x30cm, D10x28cm, D10x26,5cm 2.400, 1.400, 850 gr',
                'code' => 'CH09',
                'category_id' => 2,
                'image' => 'Produk/produk-3.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => ' Marble+teak wood | Cream D12x30cm, D10x28cm, D10x26,5cm 2.400, 1.400, 850 gr',
                'code' => 'CH09',
                'category_id' => 3,
                'image' => 'Produk/produk-3.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => ' Marble | Black | D8x11cm 500 gr',
                'code' => 'J05',
                'category_id' => 5,
                'image' => 'Produk/produk-4.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => ' Marble | Cream D30x2, D25x2, D20x2, D17x2, D15x1,5, D13,5x1,5cm 2.800, 2.000, 1.300, 800, 700, 450 gr',
                'code' => 'PT21',
                'category_id' => 6,
                'image' => 'Produk/produk-5.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => ' Marble | Cream | 10x8x2cm 250gr',
                'code' => 'SD10',
                'category_id' => 7,
                'image' => 'Produk/produk-6.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => ' Marble | Gray, Black D10x15cm | 1000 gr',
                'code' => 'V08',
                'category_id' => 8,
                'image' => 'Produk/produk-7.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => ' River Stone | D8-10×17cm 1.800gr',
                'code' => 'D03',
                'category_id' => 9,
                'image' => 'Produk/produk-8.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => ' Teak Wood | D 9x20 cm 300 gr',
                'code' => '-',
                'category_id' => 9,
                'image' => 'Produk/produk-9.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '  River Stone H30, H40, H50, H60cm',
                'code' => 'L06',
                'category_id' => 10,
                'image' => 'Produk/produk-10.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '  Marble | Cream | D14x8cm 3.500 gr',
                'code' => 'CP07',
                'category_id' => 11,
                'image' => 'Produk/produk-11.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '  Marble | 26x16x 21cm 5.000 gr',
                'code' => 'BS06',
                'category_id' => 12,
                'image' => 'Produk/produk-12.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Marble | Black | 27x15x9cm 3.600 g',
                'code' => 'B04',
                'category_id' => 13,
                'image' => 'Produk/produk-13.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => ' Marble | Cream, Gray, Black 16x10x1,5 cm | 330 gr',
                'code' => 'HD07',
                'category_id' => 14,
                'image' => 'Produk/produk-14.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => ' Marble | D40-60x15 cm 20-25 kg',
                'code' => 'WB0',
                'category_id' => 15,
                'image' => 'Produk/produk-15.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
    
        DB::table('catalogs')->insert($catalogs);
    }
}
