<?php

namespace App\Service;

use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class ChatService
{
    public function getActiveConversation($userId): Conversation|null
    {
        $conversation1 = Conversation::where('receiver_id', $userId)->where('sender_id', Auth::id())->first();
        $conversation2 = Conversation::where('receiver_id', Auth::id())->where('sender_id', $userId)->first();

        return $conversation1 ?? $conversation2;
    }
}
