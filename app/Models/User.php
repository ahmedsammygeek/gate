<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\University;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
class User extends Authenticatable
{

    const ADMIN = 1;
    const USER = 2;
    const TRAINER = 3;

    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function image(): Attribute
    {
        return new Attribute(
            get: fn($value) => is_null($value) ? 'user-default.png' : $value
        );
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class , 'user_id' );
    }

    public function university()
    {
        return $this->belongsTo(University::class );
    }

    public function installments()
    {
        return $this->hasMany(UserInstallments::class  , 'user_id');
    }

    public function courses()
    {
        return $this->hasMany(UserCourse::class , 'user_id' );
    }

    public function routeNotificationForWhatsApp()
    {
        return $this->phone;
    }
}
