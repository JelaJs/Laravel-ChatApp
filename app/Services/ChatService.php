<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatService
{
    public function getConversation($userId)
    {
        $conversation = $this->getActiveConversation($userId);

        if($conversation) {
            return $conversation;
        }

        return Conversation::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $userId,
            'conversation_id' => Str::uuid(),
        ]);
    }

    public function getActiveConversation($userId)
    {
        $conversation1 = Conversation::where('receiver_id', $userId)->where('sender_id', Auth::id())->first();
        $conversation2 = Conversation::where('receiver_id', Auth::id())->where('sender_id', $userId)->first();

        return $conversation1 ?? $conversation2;
    }

    public function createMessage($message, $conversationId)
    {
        Chat::create([
            'sender_id' => Auth::id(),
            'conversation_id' => $conversationId,
            'message' => $message
        ]);
    }
}
