<?php

use App\Http\Controllers\ActivityController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Symfony\Component\HttpKernel\Profiler\Profile;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::controller(AuthController::class)->group(function(){
    Route::get('register' , 'register')->name('register') ;
    Route::post('register' , 'registerSave')->name('register.save') ;

    Route::get('login' , 'login')->name('login') ;
    Route::post('login' , 'loginAction')->name('login.action') ;

});


Route::group(['middleware' => 'auth'] , function(){
    // Logout
    Route::get('/logout' , [AuthController::class , 'logout'])->name('logout') ;

    // Home page
    Route::get('/home' , [HomeController::class , 'index'])->name('home');

    // Posts create
    Route::get('/post/create' , [PostController::class  , 'create']) ;

    Route::post('/uploadPic' , [PostController::class , 'upload'])->name('upload.pic');

    Route::post('/store' , [PostController::class , 'store']) ;

    // Posts edit
    Route::get('/post/{post}/edit' , [PostController::class , 'edit'])->where('post' , '[0-9]+') ;
    Route::put('/post/{post}' , [PostController::class , 'update'])->where('post' , '[0-9]+') ;

    // Posts delete
    Route::delete('/post/{post}' , [PostController::class , 'destroy'])->where('post' , '[0-9]+') ;

    // Comments & reports
    Route::post('/comment' , [PostController::class , 'comment']) ;
    Route::get('/report/{post}' , [PostController::class , 'report']) ;
    Route::post('/report/{post}' , [PostController::class , 'reportStore']) ;

    // Likes and Dislikes
    Route::post('/post/{post}/like', [PostController::class, 'like'])->name('posts.like');

    Route::post('/post/{post}/dislike', [PostController::class, 'dislike'])->name('posts.dislike');

    // Posts show
    Route::get('/post/{post}' , [PostController::class  , 'show'])->where('post' , '[0-9]+') ;

    // Chat
    Route::get('/chatLogin', function(){
        return view('chat.index') ;
    });
    Route::get('/chatRoom', function(){
        return view('chat.chat') ;
    });

    // Profile follow and unfollow
    Route::post('/profile/{profile}/follow' , [ProfileController::class , 'follow'])->where('profile' , '[0-9]+')->name('profile.follow') ;

    Route::delete('/profile/{profile}/unfollow' , [ProfileController::class , 'unfollow'])->where('profile' , '[0-9]+')->name('profile.unfollow') ;

    // Profile Edit
    Route::get('/profile/{profile}/edit' , [ProfileController::class , 'edit'])->where('profile' , '[0-9]+') ;
    Route::put('/profile/{profile}' , [ProfileController::class , 'update'])->where('profile' , '[0-9]+') ;

    // Profile show
    Route::get('/profile/{profile}' , [ProfileController::class , 'show'])->where('profile' , '[0-9]+') ;


    // Activity
    Route::get('/activity' , [ActivityController::class , 'activity']) ;
    Route::get('/activity/likes' , [ActivityController::class , 'likes']) ;
    Route::get('/activity/dislikes' , [ActivityController::class , 'dislikes']) ;
    Route::get('/activity/posts' , [ActivityController::class , 'posts']) ;


    // Followpage
    Route::get('/followPage' , [ProfileController::class , 'pFollowers']) ;
    Route::get('/followPage/followers' , [ProfileController::class , 'pFollowers']) ;
    Route::get('/followPage/followings' , [ProfileController::class , 'pFollowings']) ;

});