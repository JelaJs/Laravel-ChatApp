<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\MessageRequest;
use App\Models\Chat;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function show(User $user)
    {
        $conversation = $this->getActiveConversation($user->id);

        if(!$conversation) {
            $conversation = Conversation::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $user->id,
                'conversation_id' => Str::uuid(),
            ]);
        }

        $chat = Chat::where('conversation_id', $conversation->conversation_id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chat', [
            'receive_user' => $user,
            'conversation_id' => $conversation->conversation_id,
            'chat' => $chat,
        ]);
    }

    public function sendMessage(MessageRequest $request)
    {
        $conversation = $this->getActiveConversation($request->receiver_id);
        MessageSent::dispatch($request->message, Auth::id(), $request->receiver_id, $conversation->conversation_id);

        Chat::create([
            'sender_id' => Auth::id(),
            'conversation_id' => $conversation->conversation_id,
            'message' => $request->message
        ]);
    }

    public function getActiveConversation($userId)
    {
        $conversation1 = Conversation::where('receiver_id', $userId)->where('sender_id', Auth::id())->first();
        $conversation2 = Conversation::where('receiver_id', Auth::id())->where('sender_id', $userId)->first();

        return $conversation1 ?? $conversation2;
    }
}
