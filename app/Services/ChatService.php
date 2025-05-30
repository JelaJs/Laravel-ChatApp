<?php

namespace App\Services;

use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatService
{
    public function getConversation($userId)
    {
        $conversation1 = Conversation::where('receiver_id', $userId)->where('sender_id', Auth::id())->first();
        $conversation2 = Conversation::where('receiver_id', Auth::id())->where('sender_id', $userId)->first();

        if(!$conversation1 && !$conversation2) {
            return Conversation::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $userId,
                'conversation_id' => Str::uuid(),
            ]);
        } else {
            return $conversation1 ?? $conversation2;
        }
    }
}
