<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {
            Product::create([
                'name' => $faker->word,
                'photo' => 'product' . $i . '.jpg',
                'price' => $faker->randomFloat(2, 5000, 100000),
            ]);
        }
    }
}
