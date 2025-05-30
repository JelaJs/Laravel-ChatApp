<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function show(User $user)
    {
        $conversation = null;
        $conversation1 = Conversation::where('receiver_id', $user->id)->where('sender_id', Auth::id())->first();
        $conversation2 = Conversation::where('receiver_id', Auth::id())->where('sender_id', $user->id)->first();

        if(!$conversation1 && !$conversation2) {
           $conversation = Conversation::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $user->id,
                'conversation_id' => Str::uuid(),
            ]);
        } else {
            $conversation = $conversation1 ?? $conversation2;
        }

        $chat = Chat::where('conversation_id', $conversation->conversation_id)->get();
        return view('chat', [
            'receive_user' => $user,
            'conversation_id' => $conversation->conversation_id,
            'chat' => $chat,
        ]);
    }

    public function sendMessage(Request $request)
    {
        $conversation1 = Conversation::where('receiver_id', $request->receiver_id)->where('sender_id', Auth::id())->first();
        $conversation2 = Conversation::where('receiver_id', Auth::id())->where('sender_id', $request->receiver_id)->first();

        $conversation = $conversation1 ?? $conversation2;
        MessageSent::dispatch($request->message, Auth::id(), $request->receiver_id, $conversation->conversation_id);

        Chat::create([
            'sender_id' => Auth::id(),
            'conversation_id' => $conversation->conversation_id,
            'message' => $request->message
        ]);
    }
}
