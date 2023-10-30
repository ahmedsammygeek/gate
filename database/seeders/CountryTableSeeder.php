<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::create([
            'name' => 'مصر',
            'user_id' =>1
        ]);

        Country::create([
            'name' => 'المملكة العربية السعودية',
            'user_id' =>1
        ]);

    }
}
