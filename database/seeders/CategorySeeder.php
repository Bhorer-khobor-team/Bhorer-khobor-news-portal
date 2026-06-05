<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // 12 Bengali categories
        $categories = [
            'জাতীয়',
            'আন্তর্জাতিক',
            'বাণিজ্য',
            'বিনোদন',
            'পর্যটন',
            'খেলাধুলা',
            'সারাদেশ',
            'তথ্যপ্রযুক্তি',
            'ক্যারিয়ার',
            'মতামত',
            'ক্যাম্পাস',
            'সাহিত্য',
        ];

        foreach ($categories as $index => $name) {
            Category::firstOrCreate(
                ['name' => $name],
                [
                    // Bengali text gives empty slug — fallback to category-N
                    'slug' => Str::slug($name) ?: 'category-' . ($index + 1),
                    'order' => $index + 1,
                    'status' => 'active',
                ]
            );
        }
    }
}
