<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    public function notifications(){
        $posts = CustomAuth::user()->post;

        $notifications = [];

        foreach($posts as $post){
            $usersWhoLiked = $post->likes()->orderBy('created_at')->get();
            $usersWhoDisliked = $post->dislikes()->orderBy('created_at')->get();
            $usersWhoCommented = $post->comment()->orderBy('created_at')->get();

            // dd($usersWhoLiked)->toArray();

            foreach($usersWhoLiked as $user){
            $notifications[] = [
                'user_id' => $user->id,
                'post_id' => $post->id,
                'post_title' => $post->title,
                'message' => $user->name . ' <i>liked</i> your post on ' . $user->pivot->created_at . '<br>' . $post->title ,
                'type' => 'like',
                'created_at' => $user->pivot->created_at
            ];
            }

            foreach($usersWhoDisliked as $user){
            $notifications[] = [
                'user_id' => $user->id,
                'post_id' => $post->id,
                'post_title' => $post->title,
                'message' => $user->name . ' <i>disliked</i> your post on ' . $user->pivot->created_at . '<br>' . $post->title,
                'type' => 'dislike',
                'created_at' => $user->pivot->created_at
            ];
            }

            foreach($usersWhoCommented as $user){
            $notifications[] = [
                'user_id' => $user->user_id,
                'post_id' => $post->id,
                'post_title' => $post->title,
                'message' => User::find($user->user_id)->name . ' <i>commented</i> on your post on ' . $user->created_at . '<br>' . $post->title,
                'type' => 'comment',
                'created_at' => $user->created_at
            ];
            }
            
        }

        // sort notifications by created_at
        usort($notifications, function($a, $b) {
            return strtotime($b['created_at']) <=> strtotime($a['created_at']);
        });

        // dd($notifications);

        return view('activity.notifications' , [
            'notifications' => $notifications
        ]);
    }
}
