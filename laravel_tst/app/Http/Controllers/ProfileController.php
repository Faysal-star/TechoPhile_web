<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    public function show(Profile $profile){
        // profile has user , user has post
        // dd($profile->user->post) ;
        // followers
        // dd($profile->followings()->count()) ;
        return view('profile.show', [
            'profile' => $profile,
            'posts' => $profile->user->post ,
            'followers' => $profile->followers()->count(),
            'followings' => $profile->followings()->count(),
        ]) ;
    }

    public function follow(Profile $profile){
        // dd($profile) ;
        $profile->followers()->attach(auth()->user()->profile) ;
        return back() ;
    }

    public function unfollow(Profile $profile){
        $profile->followers()->detach(auth()->user()->profile) ;
        return back() ;
    }

    public function edit(Profile $profile){
        return view('profile.edit', [
            'profile' => $profile
        ]) ;
    }

    public function update(Profile $profile){
        // dd($profile) ;
        if(auth()->user()->profile->isNot($profile)){
            abort(403) ;
        }
        // protected $fillable = ['user_id' , 'name' , 'email' , 'phone' , 'address' , 'city' , 'github' , 'twitter' , 'facebook' , 'linkedin' , 'avatar' , 'bio' , 'cover'] ;

        $attributes = request()->validate([
            'name' => 'required' ,
        ]);

        $attributes['phone'] = request('phone') ;
        $attributes['address'] = request('address') ;
        $attributes['city'] = request('city') ;
        $attributes['github'] = request('github') ;
        $attributes['twitter'] = request('twitter') ;
        $attributes['facebook'] = request('facebook') ;
        $attributes['linkedin'] = request('linkedin') ;
        $attributes['github_link'] = request('github_link') ;
        $attributes['twitter_link'] = request('twitter_link') ;
        $attributes['facebook_link'] = request('facebook_link') ;
        $attributes['linkedin_link'] = request('linkedin_link') ;
        $attributes['bio'] = request('bio') ;


        if(request()->hasFile('avatar')){
            $attributes['avatar'] = request()->file('avatar')->store('avatars' , 'public') ;
        }

        if(request()->hasFile('cover')){
            $attributes['cover'] = request()->file('cover')->store('covers' , 'public') ;
        }
        // dd($attributes) ;
        $profile->update($attributes) ;

        return redirect("/profile/".$profile->id) ;
    }
    
}
