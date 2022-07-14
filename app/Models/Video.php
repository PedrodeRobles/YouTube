<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Dislike;
use App\Models\Likes;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',       
        'video',       
        'description',
        'category_id',
        'user_id',
        'likes',
        'dislikes',
        'views'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
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
