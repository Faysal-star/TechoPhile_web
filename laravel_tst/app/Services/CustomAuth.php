<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;
use App\Models\User;

class CustomAuth
{
    public function user()
    {
        $userId = Session::get('user_id');
        return $userId ? User::find($userId) : null;
    }

    public function check()
    {
        return Session::has('user_id');
    }

    public function login(User $user)
    {
        Session::put('user_id', $user->id);
    }

    public function logout()
    {
        Session::forget('user_id');
    }
}
