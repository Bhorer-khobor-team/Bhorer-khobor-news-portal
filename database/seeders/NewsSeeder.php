<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        // Get the Super Admin created by AdminSeeder
        $admin = Admin::first();
        $categories = Category::all();

        if (!$admin || $categories->isEmpty()) {
            $this->command->warn('Run AdminSeeder and CategorySeeder first!');
            return;
        }

        $articles = [
            ['title' => 'বাংলাদেশের অর্থনীতিতে নতুন দিগন্ত', 'category' => 'জাতীয়'],
            ['title' => 'ঢাকায় আন্তর্জাতিক বাণিজ্য সম্মেলন অনুষ্ঠিত', 'category' => 'বাণিজ্য'],
            ['title' => 'ক্রিকেট বিশ্বকাপে বাংলাদেশের অসাধারণ জয়', 'category' => 'খেলাধুলা'],
            ['title' => 'ঢালিউডে নতুন চলচ্চিত্রের আবির্ভাব', 'category' => 'বিনোদন'],
            ['title' => 'দেশে তথ্যপ্রযুক্তি খাতে বিনিয়োগ বৃদ্ধি', 'category' => 'তথ্যপ্রযুক্তি'],
            ['title' => 'বিশ্ব রাজনীতিতে নতুন মেরুকরণ', 'category' => 'আন্তর্জাতিক'],
            ['title' => 'পর্যটন শিল্পে রেকর্ড প্রবৃদ্ধি', 'category' => 'পর্যটন'],
            ['title' => 'চট্টগ্রামে নতুন শিল্পাঞ্চল স্থাপন', 'category' => 'সারাদেশ'],
            ['title' => 'তরুণ উদ্যোক্তাদের সাফল্যের গল্প', 'category' => 'ক্যারিয়ার'],
            ['title' => 'শিক্ষা ব্যবস্থায় ডিজিটাল রূপান্তর', 'category' => 'ক্যাম্পাস'],
            ['title' => 'বন্যায় উপকূলীয় অঞ্চলে জরুরি সহায়তা', 'category' => 'জাতীয়'],
            ['title' => 'বাংলা সাহিত্যে নতুন প্রজন্মের কবিরা', 'category' => 'সাহিত্য'],
            ['title' => 'আন্তর্জাতিক বাজারে পোশাক রপ্তানি বৃদ্ধি', 'category' => 'বাণিজ্য'],
            ['title' => 'বিশ্বকাপ ফুটবলে এশিয়ার দলগুলো', 'category' => 'খেলাধুলা'],
            ['title' => 'ডিজিটাল নিরাপত্তা নিয়ে বিশেষজ্ঞদের মতামত', 'category' => 'মতামত'],
            ['title' => 'রাজধানীতে যানজট নিরসনে নতুন পরিকল্পনা', 'category' => 'জাতীয়'],
            ['title' => 'মধ্যপ্রাচ্যে শান্তি আলোচনা শুরু', 'category' => 'আন্তর্জাতিক'],
            ['title' => 'সিলেটের চা বাগানে পর্যটকদের ভিড়', 'category' => 'পর্যটন'],
            ['title' => 'বিশ্ববিদ্যালয়ে গবেষণায় নতুন রেকর্ড', 'category' => 'ক্যাম্পাস'],
            ['title' => 'গ্রামীণ উন্নয়নে সরকারের নতুন উদ্যোগ', 'category' => 'সারাদেশ'],
        ];

        foreach ($articles as $index => $article) {
            $category = $categories->firstWhere('name', $article['category'])
                ?? $categories->first();

            News::firstOrCreate(
                ['slug' => Str::slug($article['title']) ?: 'news-' . ($index + 1)],
                [
                    'title' => $article['title'],
                    'subtitle' => $article['title'] . ' - বিস্তারিত প্রতিবেদন',
                    'body' => '<p>এটি একটি নমুনা সংবাদ নিবন্ধ। বাংলাদেশের সর্বশেষ সংবাদ ও তথ্য পেতে ভোরের খবরের সাথে থাকুন।</p>',
                    'category_id' => $category->id,
                    'admin_id' => $admin->id,
                    'status' => 'published',
                    'is_featured' => $index < 5, // first 5 articles are featured
                    'published_at' => now()->subDays(rand(0, 30)),
                    'views' => rand(10, 500),
                ]
            );
        }
    }
}
