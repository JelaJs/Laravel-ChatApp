<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function show(User $user)
    {
        return view('chat', ['receive_user' => $user]);
    }
    public function sendMessage(Request $request)
    {
        MessageSent::dispatch($request->message, Auth::id(), $request->receiver_id);
    }
}
