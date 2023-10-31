<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
class Category extends Model
{
    use HasFactory;

    use HasTranslations;

    public $translatable = ['name'];
    protected $guarded = ['id', 'created_at', 'updated_at'];



    public function user()
    {
       return $this->belongsTo(User::class);
    }


}
