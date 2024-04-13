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

    
}
