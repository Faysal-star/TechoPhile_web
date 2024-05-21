<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        // dd(request('tags')) ;
        // dd(request(['tag'])) ;
        // $posts = Post::latest()->filter(request(['tag']))->get() ;
        // dd($posts) ;
        return view('home', [
            'posts' => Post::filter(request(['tag', 'search']))
                            ->orderBy('impact_factor', 'desc')
                            ->simplePaginate(10)
        ]);
    }

    public function admin(){
        return view('admin') ;
    }
}
