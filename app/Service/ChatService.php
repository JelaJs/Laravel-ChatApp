<?php

namespace App\Service;

use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class ChatService
{
    public function getActiveConversation(int $userId): Conversation|null
    {
        $conversation1 = Conversation::where('receiver_id', $userId)->where('sender_id', Auth::id())->with('messages')->first();
        $conversation2 = Conversation::where('receiver_id', Auth::id())->where('sender_id', $userId)->with('messages')->first();

        return $conversation1 ?? $conversation2;
    }
}
