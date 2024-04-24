<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Profile;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function type(): Attribute{
        return new Attribute(
            get: fn ($value) => ["user" , "admin"][$value],
        ) ;
    }

    public function post(){
        return $this->hasMany(Post::class) ;
    }

    public function comment(){
        return $this->hasMany(Comment::class);
    }

    public function profile(){
        return $this->hasOne(Profile::class);
    }

    public function likes(){
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id')
                    ->wherePivot('type', '=' , 'like');
    }

    public function dislikes(){
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id')
                    ->wherePivot('type', '=' , 'dislike');
    }

}
