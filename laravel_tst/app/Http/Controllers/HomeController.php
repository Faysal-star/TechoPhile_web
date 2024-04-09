<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        // dd(request('tag')) ;
        return view('home' , [
            'posts' => Post::latest()->filter(request(['tag']))->get()
        ]) ;
    }
}
