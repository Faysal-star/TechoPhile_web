<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id' , 'name' , 'email' , 'phone' , 'address' , 'city' , 'github' , 'twitter' , 'facebook' , 'linkedin' , 'avatar' , 'bio' , 'cover'] ;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function followers()
    {
        return $this->belongsToMany(Profile::class, 'followers', 'following_id', 'follower_id');
    }

    public function followings()
    {
        return $this->belongsToMany(Profile::class, 'followers', 'follower_id', 'following_id');
    }

    public function isFollowing(Profile $profile)
    {
        // dd($this->followings()->where('follower_id', auth()->user()->id)->where('following_id', $profile->id)->exists());
        return $this->followings()->where('follower_id', auth()->user()->id)->where('following_id', $profile->id)->exists();
    }

}
