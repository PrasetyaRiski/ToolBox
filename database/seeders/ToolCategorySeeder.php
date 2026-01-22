<?php

namespace Database\Seeders;

use App\Models\ToolCategory;
use Illuminate\Database\Seeder;

class ToolCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tools Teks',
                'slug' => 'text-tools',
                'icon' => '✍️',
                'description' => 'Tools untuk manipulasi dan konversi teks',
                'order' => 1,
            ],
            [
                'name' => 'Tools Coding',
                'slug' => 'coding-tools',
                'icon' => '⚡',
                'description' => 'Tools developer dan utilitas kode',
                'order' => 2,
            ],
            [
                'name' => 'Tools Warna',
                'slug' => 'color-tools',
                'icon' => '🎨',
                'description' => 'Tools konversi warna dan palet',
                'order' => 3,
            ],
            [
                'name' => 'Tools Lainnya',
                'slug' => 'miscellaneous-tools',
                'icon' => '⚙️',
                'description' => 'Utilitas berguna lainnya',
                'order' => 4,
            ],
        ];

        foreach ($categories as $category) {
            ToolCategory::create($category);
        }
    }
}
