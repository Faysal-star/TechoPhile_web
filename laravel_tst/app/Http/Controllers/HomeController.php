<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Report;
use App\Facades\CustomAuth;
use Illuminate\Http\Request;
use App\Models\ReportNotification;

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
}
