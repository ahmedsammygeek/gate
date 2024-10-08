<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;
class University extends Model
{
    use HasFactory;

    use HasTranslations;

    public $translatable = ['title' ,  'content', 'slug' ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'university_id');
    }
}
