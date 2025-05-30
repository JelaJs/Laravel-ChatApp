<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\MessageRequest;
use App\Models\Chat;
use App\Models\User;
use App\Services\ChatService;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function show(ChatService $chatService, User $user)
    {
        $conversation = $chatService->getConversation($user->id);

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
        $conversation = $chatService->getConversation($request->receiver_id);
        MessageSent::dispatch($request->message, Auth::id(), $request->receiver_id, $conversation->conversation_id);

        $chatService->createMessage($request->message, $conversation->conversation_id);
    }
}
