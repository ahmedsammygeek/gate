<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'برمجة', 'user_id' =>1 ,'is_active' => 1]);
        Category::create(['name' => 'فنون و تصميم', 'user_id' =>1, 'is_active' => 1 ]);
        Category::create(['name' => 'اللغات', 'user_id' =>1, 'is_active' => 1]);
        Category::create(['name' => 'علوم البيانات', 'user_id' =>1, 'is_active' => 1]);
        Category::create(['name' => 'كتابة المحتوي', 'user_id' =>1, 'is_active' => 1]);
        Category::create(['name' => 'اللإدارة', 'user_id' =>1, 'is_active' => 1]);
    }
}
