<?php

namespace App\Http\Controllers;

use App\Models\chatRoom;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chatLogin(){
        return view('chat.index', [
            'rooms' => chatRoom::all()
        ]) ;
    }
}
