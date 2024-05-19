<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Facades\CustomAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        // dd(CustomAuth::check());
        return view('auth/login') ;
    }

    public function loginAction(){
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // if(auth()->attempt($attributes)){
        //     request()->session()->regenerate();
        //     return redirect()->route('home');
        // }
        $user = \App\Models\User::where('email', $attributes['email'])->first();

        if ($user && Hash::check($attributes['password'], $user->password)) {
            CustomAuth::login($user);
            request()->session()->regenerate();

            // dd(CustomAuth::user()->profile) ;
            // $authUser = CustomAuth::user();
            // view()->share('authUser', $authUser);

            return redirect()->route('home');
        }
    


        return back()->withErrors(['email' => 'Your provided credentials could not be verified!']);
   
    }

    public function logout(){
        CustomAuth::logout();
        return redirect()->route('login');
    }
}
