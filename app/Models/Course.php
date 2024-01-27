<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Models\CourseUnit;
use App\Models\CourseReview;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    use HasTranslations;

    const COURSE = 1 ;
    const PACKAGE = 2 ;

    protected $casts = [

        'ends_at' => 'date' ,
    ];

    public $translatable = ['title' , 'subtitle' , 'slug' , 'content' , 'curriculum' ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function trainer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class,'university_id');
    }

    public function courseReviews(): HasMany
    {
        return $this->hasMany(CourseReview::class, 'course_id');
    }


    public function getOldPrice()
    {
        return $this->price;
    }


    public function hasDiscount()
    {
        if ($this->price_after_discount) {
            return true;
        }

        return false;
    }

    public function getPrice()
    {
        if ($this->price_after_discount) {
            return $this->price_after_discount;
        }

        return $this->price;
    }

    public function courses()
    {
        return $this->hasMany(Package::class , 'main_course_id');
    }


    public function units(): HasMany
    {
        return $this->hasMany(CourseUnit::class, 'course_id');
    }

    public function installments($value='')
    {
        return $this->hasMany(CourseInstallment::class , 'course_id');
    }


    public function lessons()
    {
        return $this->hasManyThrough( Lesson::class , CourseUnit::class );
    }

    public function availableForPurchase()
    {
        return true;
    }
}
