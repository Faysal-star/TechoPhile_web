<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function activity()
    {
        // first liked post
        // $firstLikedPost = auth()->user()->likes->first();
        // dd($firstLikedPost->id);
        return redirect('/activity/likes');
    }

    public function likes()
    {
        return view('activity.likes' , [
            'likes' => auth()->user()->likes
        ]);
    }

    public function dislikes()
    {
        return view('activity.dislikes' , [
            'dislikes' => auth()->user()->dislikes
        ]);
    }

    public function posts()
    {
        // dd(auth()->user()->post);
        return view('activity.posts' , [
            'posts' => auth()->user()->post
        ]);
    }
}
