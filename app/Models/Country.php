<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
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
