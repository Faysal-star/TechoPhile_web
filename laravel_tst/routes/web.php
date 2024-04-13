<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Symfony\Component\HttpKernel\Profiler\Profile;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function(){
    Route::get('register' , 'register')->name('register') ;
    Route::post('register' , 'registerSave')->name('register.save') ;

    Route::get('login' , 'login')->name('login') ;
    Route::post('login' , 'loginAction')->name('login.action') ;

});


Route::group(['middleware' => 'auth'] , function(){
    Route::get('/home' , [HomeController::class , 'index'])->name('home');

    Route::get('/post/create' , [PostController::class  , 'create']) ;

    Route::post('/uploadPic' , [PostController::class , 'upload'])->name('upload.pic');

    Route::post('/store' , [PostController::class , 'store']) ;

    Route::post('/comment' , [PostController::class , 'comment']) ;
    
    Route::get('/post/{post}' , [PostController::class  , 'show'])->where('id' , '[0-9]+') ;

    Route::get('/chatLogin', function(){
        return view('chat.index') ;
    });
    Route::get('/chatRoom', function(){
        return view('chat.chat') ;
    });

    Route::post('/profile/{profile}/follow' , [ProfileController::class , 'follow'])->where('id' , '[0-9]+')->name('profile.follow') ;

    Route::delete('/profile/{profile}/unfollow' , [ProfileController::class , 'unfollow'])->where('id' , '[0-9]+')->name('profile.unfollow') ;


    Route::get('/profile/{profile}' , [ProfileController::class , 'show'])->where('id' , '[0-9]+') ;

    
});