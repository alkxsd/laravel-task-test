<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Work', 'color' => 'sky'],
            ['name' => 'Personal', 'color' => 'warning'],
            ['name' => 'Home', 'color' => 'positive'],
            ['name' => 'Shopping', 'color' => 'negative'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
