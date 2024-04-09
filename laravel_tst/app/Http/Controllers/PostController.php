<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Post $post){
        // dd($post) ;
        return view('posts/singlePost' , [
            'post' => $post
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


}
