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

        $profile = $user->profile()->create([
            'user_id' => $user->id,
            'name' => $attributes['name'],
            'email' => $attributes['email']
        ]);

        // auth()->login($user);

        return redirect()->route('login') ;


    }

    public function login(){
        return view('auth/login') ;
    }

    public function loginAction(){
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(auth()->attempt($attributes)){
            request()->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors(['email' => 'Your provided credentials could not be verified!']);
   
    }

    public function logout(){
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    }
}
