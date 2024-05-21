<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Report;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Facades\CustomAuth;

class PostController extends Controller
{
    public function show(Post $post){
        // dd($post) ;
        // dd($post->comment) ;
        // dd($post->dislikes->count()) ;
        // dd($post->likes->count()) ;
        // dd($post->comment->count()) ; 
        // see if the user has liked the post
        // $liked = CustomAuth::user()->likes->contains($post);
        // dd($liked);

        $comments = Comment::with('allReplies')
                            ->whereNull('parent_id')
                            ->where('post_id', $post->id)
                            ->get();

        // dd($comments->toArray());

        return view('posts/singlePost' , [
            'post' => $post,
            'comments' => $comments,
            'likes' => $post->likes->count(),
            'dislikes' => $post->dislikes->count(),
            'commentsCount' => $post->comment->count(),
            'liked' => CustomAuth::user()->likes->contains($post),
            'disliked' => CustomAuth::user()->dislikes->contains($post)
        ]);
    }

    public function create(){
        return view('posts/create') ;
    }

    public function upload(){
        if(request()->hasFile('upload')){
            $originName = request()->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName , PATHINFO_FILENAME) ;
            $extension = request()->file('upload')->getClientOriginalExtension() ;
            $fileName = $fileName.'_'.time().'.'.$extension ;

            // $fileName = request()->file('upload')->store('upload' , 'public');
    
            request()->file('upload')->move(public_path('uploaded') , $fileName) ;

            $url = asset('uploaded/' .$fileName) ;

            return response()->json([
                'fileName' => $fileName ,
                'uploaded' => 1 ,
                'url' => $url 
            ]);

        }
    }

    public function store(){
        $attributes = request()->validate([
            'title' => 'required' ,
            'tags' => 'required',
            'body' => 'required'
        ]);

        $attributes['user_id'] = CustomAuth::user()->id;

        Post::create($attributes) ;

        return redirect('/home')->with('success' , 'Your post has been created!') ;
    }

    public function comment(){
        $attributes = request()->validate([
            'post_id' => 'required',
            'body' => 'required'
        ]);
        
        if(request()->has('parent_id')){
            $attributes['parent_id'] = request('parent_id');
        }

        $attributes['user_id'] = CustomAuth::user()->id;
        $postId = $attributes['post_id'];

        Comment::create($attributes) ;

        return redirect('/post/'.$postId) ;

    }

    public function like(Post $post){
        if(CustomAuth::user()->likes->contains($post)){
            CustomAuth::user()->likes()->detach($post->id);
        }
        else if(CustomAuth::user()->dislikes->contains($post)){
            CustomAuth::user()->dislikes()->detach($post->id);
            CustomAuth::user()->likes()->attach($post->id, ['type' => 'like']);
        }
        else{
            CustomAuth::user()->likes()->attach($post->id, ['type' => 'like']);
        }

        $like_count = $post->likes->count();
        $dislike_count = $post->dislikes->count();
        $comments_count = $post->comment->count();
        $created_at = $post->created_at;
        $elapsed_day = $created_at->diffInDays(now());

        // dd($like_count, $dislike_count, $comments_count, $elasped_day);
        $impact_factor = 1 + $like_count * 70 + $comments_count * 70 - $elapsed_day * 2 - $dislike_count * 38;
        $post->update(['impact_factor' => $impact_factor]);
        // dd($impact_factor);

        return back();
    }

    public function dislike(Post $post){
        if(CustomAuth::user()->dislikes->contains($post)){
            CustomAuth::user()->dislikes()->detach($post->id);
        }
        else if(CustomAuth::user()->likes->contains($post)){
            CustomAuth::user()->likes()->detach($post->id);
            CustomAuth::user()->dislikes()->attach($post->id, ['type' => 'dislike']);
        }
        else{
            CustomAuth::user()->dislikes()->attach($post->id, ['type' => 'dislike']);
        }

        $like_count = $post->likes->count();
        $dislike_count = $post->dislikes->count();
        $comments_count = $post->comment->count();
        $created_at = $post->created_at;
        $elapsed_day = $created_at->diffInDays(now());

        // dd($like_count, $dislike_count, $comments_count, $elasped_day);
        $impact_factor = 1 + $like_count * 70 + $comments_count * 70 - $elapsed_day * 2 - $dislike_count * 38;
        $post->update(['impact_factor' => $impact_factor]);

        return back();
    }

    public function report(Post $post){
        // dd(Report::all());
        // $first = Report::all()->first();
        // dd($first->user->name);
        return view('posts/report' , [
            'post' => $post
        ]);
    }

    public function reportStore(Post $post){
        $attributes = request()->validate([
            'reportBody' => 'required'
        ]);

        $attributes['user_id'] = CustomAuth::user()->id;
        $attributes['post_id'] = $post->id;

        Report::create($attributes) ;

        return redirect('/post/'.$post->id);
    }

    public function edit(Post $post){
        return view('posts/edit' , [
            'post' => $post
        ]);
    }

    public function update(Post $post){
        $attributes = request()->validate([
            'title' => 'required' ,
            'tags' => 'required',
            'body' => 'required'
        ]);

        $post->update($attributes) ;

        return redirect('/post/'.$post->id) ;
    }

    public function destroy(Post $post){
        if(CustomAuth::user()->id != $post->user_id){
            abort(403);
        }
        $post->delete() ;

        return redirect()->back();
    }
}
