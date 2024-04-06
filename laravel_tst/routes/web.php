<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function(){
    Route::get('register' , 'register')->name('register') ;
    Route::post('register' , 'registerSave')->name('register.save') ;
});
