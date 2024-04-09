<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;

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
});