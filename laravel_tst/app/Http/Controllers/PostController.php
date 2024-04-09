<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Post $post){
        // dd($post) ;
        // dd($post->comment) ;
        return view('posts/singlePost' , [
            'post' => $post,
            'comments' => $post->comment
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

        $attributes['user_id'] = auth()->id();

        Post::create($attributes) ;

        return redirect('/home')->with('success' , 'Your post has been created!') ;
    }

    public function comment(){
        $attributes = request()->validate([
            'post_id' => 'required',
            'body' => 'required'
        ]);

        $attributes['user_id'] = auth()->id();
        $postId = $attributes['post_id'];

        Comment::create($attributes) ;

        return redirect('/post/'.$postId) ;

    }


}
