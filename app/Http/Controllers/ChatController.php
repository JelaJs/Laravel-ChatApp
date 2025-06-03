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

class ChatController extends Controller
{
    public function show(ChatService $chatService, User $user)
    {
        $conversation = $chatService->getActiveConversation($user->id);

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

    public function sendMessage(MessageRequest $request, ChatService $chatService)
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
