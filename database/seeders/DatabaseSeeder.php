<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User (Opsional)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 2. Buat 3 Kategori
        $categories = [
            ['name' => 'Elektronik', 'description' => 'Gadget dan alat elektronik'],
            ['name' => 'Pakaian', 'description' => 'Fashion pria dan wanita'],
            ['name' => 'Makanan', 'description' => 'Makanan ringan dan berat'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // 3. Buat 30 Produk Dummy
        $faker = \Faker\Factory::create();

        // Ambil semua ID kategori yang baru dibuat
        $categoryIds = Category::pluck('id')->toArray();

        for ($i = 1; $i <= 30; $i++) {
            Product::create([
                'category_id' => $categoryIds[array_rand($categoryIds)], // Pilih kategori acak
                'name' => 'Produk ' . $i . ' - ' . $faker->word,
                'description' => $faker->sentence(10),
                'price' => $faker->numberBetween(10000, 500000),
            ]);
        }
    }
}
