<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(){
        return view('auth/register') ;
    }

    public function registerSave(){
        $attributes = request()->validate([
            'name' => 'required|min:3',
            'email' => ['required' , 'email' , 'unique:users,email'],
            'password' => ['required' , 'confirmed' , 'min:6']
        ]);

        $attributes['password'] = bcrypt($attributes['password']);
        $attributes['type'] = "0" ;

        $user = User::create($attributes);

        // auth()->login($user);

        return redirect()->route('login') ;


    }
}
