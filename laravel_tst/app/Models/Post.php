<?php

namespace App\Models;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title' , 'user_id' , 'body' , 'tags' , 'impact_factor'] ;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query , array $filters){
        if($filters['tag'] ?? false){
            $query->where('tags' , 'like' , '%'.request('tag').'%') ; 
        }

        if($filters['search'] ?? false){
            $query->where('title' , 'like' , '%'.request('search').'%')
                    ->orWhere('body' , 'like' , '%'.request('search').'%')
                    ->orWhere('tags' , 'like' , '%'.request('search').'%');
        }
    }

    public function comment(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id')
                    ->wherePivot('type', '=' ,'like');
    }

    public function dislikes(){
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id')
                    ->wherePivot('type', '=' , 'dislike');
    }
}
