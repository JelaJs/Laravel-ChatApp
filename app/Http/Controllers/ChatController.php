<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\MessageRequest;
use App\Models\Chat;
use App\Models\Conversation;
use App\Models\User;
use App\Service\ChatService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function show(ChatService $chatService, User $user): View
    {
        $conversation = $chatService->getActiveConversation($user->id);

        if(!$conversation) {
            $conversation = Conversation::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $user->id,
                'conversation_id' => Str::uuid(),
            ]);
        }

        return view('chat', [
            'receive_user' => $user,
            'conversation' => $conversation,
        ]);
    }

    public function sendMessage(MessageRequest $request, ChatService $chatService): void
    {
        $conversation = $chatService->getActiveConversation($request->receiver_id);
        MessageSent::dispatch($request->message, Auth::id(), $request->receiver_id, $conversation->conversation_id);

        Chat::create([
            'sender_id' => Auth::id(),
            'conversation_id' => $conversation->conversation_id,
            'message' => $request->message
        ]);
    }
}
