<?php

namespace App\Http\Controllers;

use App\Facades\CustomAuth;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function activity()
    {
        // first liked post
        // $firstLikedPost = CustomAuth::user()->likes->first();
        // dd($firstLikedPost->id);
        return redirect('/activity/likes');
    }

    public function likes()
    {
        return view('activity.likes' , [
            'likes' => CustomAuth::user()->likes
        ]);
    }

    public function dislikes()
    {
        return view('activity.dislikes' , [
            'dislikes' => CustomAuth::user()->dislikes
        ]);
    }

    public function posts()
    {
        // dd(CustomAuth::user()->post);
        return view('activity.posts' , [
            'posts' => CustomAuth::user()->post
        ]);
    }
}
