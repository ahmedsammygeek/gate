<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;
use Str;
class TrainersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        for ($i=0; $i < 10 ; $i++) { 
            
            $user = new User;
            $user->name = 'trainer number '.$i;
            $user->email = Str::uuid().'@gmail.com';
            $user->password = Hash::make(90909090);
            $user->user_id = 1;
            $user->type = 3;
            $user->job_title = 'user job title here';
            $user->is_banned = 0;
            $user->phone = '010'.substr(str_shuffle('0123456789'), 0 , 8 );
            $user->facebook = 'https://www.facebook.com/';
            $user->instagram = 'https://www.instagram.com/';
            $user->twitter = 'https://twitter.com/?lang=ar';
            $user->save();
        }
    }
}
