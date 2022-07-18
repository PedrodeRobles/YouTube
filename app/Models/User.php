<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Video;
use App\Models\Comment;
use App\Models\Subscriber;
use App\Models\Likes;
use App\Models\Dislike;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'subscribers',
        'profile_image',
        'bg_image',
        'information',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function videos() 
    {
        return $this->hasMany(Video::class);
    }

    public function comments() 
    {
        return $this->hasMany(Comment::class);
    }

    public function subscribers() 
    {
        return $this->hasMany(Subscriber::class);
    }

    public function likes() 
    {
        return $this->hasMany(Likes::class);
    }

    public function dislikes() 
    {
        return $this->hasMany(Dislike::class);
    }
}
