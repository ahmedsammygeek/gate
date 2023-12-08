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
        Category::create(['name->ar' => 'فنون و تصميم',  'name->en' => 'فنون و تصميم' ,  'user_id' =>1, 'is_active' => 1  , ]);
        Category::create(['name->ar' => 'العلوم التطبيقيه',  'name->en' => 'applied Sciences' ,  'user_id' =>1, 'is_active' => 1 , ]);
        Category::create(['name->ar' => 'علوم البيانات',  'name->en' => 'Data science' ,  'user_id' =>1, 'is_active' => 1 , ]);
        Category::create(['name->ar' => 'التصوير', 'name->en' =>'Photography'  ,  'user_id' =>1, 'is_active' => 1 , ]);
        Category::create(['name->ar' => 'اللإدارة',  'name->en' => 'Mangement' ,  'user_id' =>1, 'is_active' => 1 , ]);
    }
}
