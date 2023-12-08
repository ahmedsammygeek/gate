<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\University;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Str;
use Storage;
class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            'https://www.smartpassiveincome.com/wp-content/uploads/2020/04/How-to-Create-an-Online-Course.png' , 
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRIhg-aaxfGQDcxiYNQiIACqfy3M3vwy_JFcQ&usqp=CAU' , 
            'https://www.ox.ac.uk/sites/files/oxford/styles/ow_large_feature/s3/field/field_image_main/b_AllSoulsquad.jpg?itok=tTcH-5ix' , 
            'https://images.ctfassets.net/lzny33ho1g45/5yHk3Hjp7kyiRdRYiO0fiM/813d5fb1324378e881961666484c1da9/Online_course_platforms.jpg' , 
            'https://images.prismic.io/thinkific/df035890-508b-4971-be1b-30b707167aa4_OnlineCourses_1_course_templates.webp?auto=compress,format' , 
            'https://www.theopencollege.com/wp-content/uploads/2013/07/fetac-business-management1.jpg' , 
            'https://learning.linkedin.com/content/dam/me/business/en-us/amp/talent-solutions/images/course-club/sign-up/social/Course-Club-Sign-Up-socialshare-image.png' , 
            'https://www.edinburghcollege.ac.uk/media/c5ghakxe/pexels-tirachard-kumtanom-733856.jpg?center=0.40242891032492345,0.50277250251192762&mode=crop&quality=80&width=780&height=400&rnd=132717830764430000' , 
        ];


        // foreach ($universities as $university) {

        // }
        $ar_content = 'وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق "ليتراسيت" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل "ألدوس بايج مايكر" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم. 
        وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق "ليتراسيت" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل "ألدوس بايج مايكر" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم. 

        وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق "ليتراسيت" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل "ألدوس بايج مايكر" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم. 

        وريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق "ليتراسيت" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل "ألدوس بايج مايكر" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم. 
        ';
        $en_content = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.


        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';






        for ($i=0; $i < 100 ; $i++) { 
            $new_course = new Course;
            $new_course->setTranslation('title' , 'ar' , 'اسم الكورس بالعربيه '.$i );
            $new_course->setTranslation('title' , 'en' , 'course english name '.$i );
            $new_course->setTranslation('subtitle' , 'ar' , 'هنا يتم وضع نبذه عن الكورس او الدوره بشكل بيسيط'.$i );
            $new_course->setTranslation('subtitle' , 'en' , 'course english subtitles here to put  '.$i );
            $new_course->setTranslation('content' , 'ar'  , $ar_content );
            $new_course->setTranslation('content' , 'en'  , $en_content );
            $new_course->setTranslation('curriculum' , 'ar'  , $ar_content );
            $new_course->setTranslation('curriculum' , 'en'  , $en_content );
            $new_course->setTranslation('slug' , 'ar'  , str_replace(' ', '-', 'اسم الكورس بالعربيه '.$i ) );
            $new_course->setTranslation('slug' , 'en'  , str_replace(' ', '-', 'course english name '.$i ) );
            $new_course->university_id = University::all()->random(1)->first()->id;;
            $new_course->category_id = Category::all()->random(1)->first()->id;
            $new_course->price = rand(0 ,10000);
            $new_course->price_later = rand(0 ,10000);
            $new_course->user_id = 1;
            $new_course->show_in_home = 1;
            $new_course->type = rand(1 , 2);
            $new_course->students_number = rand(200, 3000);
            $new_course->reviews = 5;
            $new_course->trainer_id = User::where('type' , 3 )->inRandomOrder()->first()->id;;
            $random_image  = $images[mt_rand(0 , count($images) - 1 )];
            $image_name = Str::uuid();
            Storage::put('courses/'.$image_name.'.jpg', file_get_contents($random_image) );
            $new_course->image = $image_name.'.jpg';;
            $new_course->save();
        }

        // foreach ($images as $image) {
        //     $i = 1;
        //     $new_course = new Course;
        //     $new_course->setTranslation('title' , 'ar' , 'اسم الكورس بالعربيه '.$i );
        //     $new_course->setTranslation('title' , 'en' , 'course english name '.$i );
        //     $new_course->setTranslation('subtitle' , 'ar' , 'هنا يتم وضع نبذه عن الكورس او الدوره بشكل بيسيط'.$i );
        //     $new_course->setTranslation('subtitle' , 'en' , 'course english subtitles here to put  '.$i );
        //     $new_course->setTranslation('content' , 'ar'  , $ar_content );
        //     $new_course->setTranslation('content' , 'en'  , $en_content );
        //     $new_course->setTranslation('curriculum' , 'ar'  , $ar_content );
        //     $new_course->setTranslation('curriculum' , 'en'  , $en_content );
        //     $new_course->setTranslation('slug' , 'ar'  , str_replace(' ', '-', 'اسم الكورس بالعربيه '.$i ) );
        //     $new_course->setTranslation('slug' , 'en'  , str_replace(' ', '-', 'course english name '.$i ) );
        //     $new_course->university_id = University::all()->random(1)->first()->id;;
        //     $new_course->category_id = Category::all()->random(1)->first()->id;
        //     $new_course->price = rand(0 ,10000);
        //     $new_course->price_later = rand(0 ,10000);
        //     $new_course->user_id = 1;
        //     $new_course->show_in_home = 1;
        //     $new_course->type = rand(1 , 2);
        //     $new_course->students_number = rand(200, 3000);
        //     $new_course->reviews = 5;
        //     $new_course->trainer_id = 1;
        //     $random_image  = $image;
        //     $image_name = Str::uuid();
        //     Storage::put('courses/'.$image_name.'.jpg', file_get_contents($random_image) );
        //     $new_course->image = $image_name.'.jpg';;
        //     $new_course->save();
        // }
    }
}
