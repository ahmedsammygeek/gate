<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;
class Page extends Model
{
    use HasFactory;
    use HasTranslations, HasTranslatableSlug;
    public $translatable = ['title' , 'content' , 'slug' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
        ->generateSlugsFrom('title')
        ->saveSlugsTo('slug');
    }
}
