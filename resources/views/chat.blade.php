@php use App\Models\User; $users = User::all(); @endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div>
            @foreach($users as $user)
                @if($user->id !== auth()->id())
                    <a href="http://127.0.0.1:8000/chat/{{$user->id}}" class="users">{{$user->name}}</a>
                @endif
            @endforeach
        </div>
        <div id="chat-container"
             data-conversation-id="{{ $conversation->conversation_id }}"
             data-user-id="{{ auth()->id() }}"
             data-receiver-id="{{ $receive_user->id }}">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div id="chat-body" class="p-4 space-y-2 h-[500px] overflow-y-auto bg-gray-100 rounded-lg">
                            @if($conversation->messages)
                                @foreach($conversation->messages as $message)
                                    @if($message->sender_id == auth()->id())
                                        <!-- Sent message (by me) -->
                                        <div class="flex justify-end">
                                            <div class="bg-blue-500 text-white px-4 py-2 rounded-lg max-w-xs text-sm shadow">
                                                <p>{{ $message->message }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Received message (from others) -->
                                        <div class="flex justify-start">
                                            <div class="bg-gray-300 text-black px-4 py-2 rounded-lg max-w-xs text-sm shadow">
                                                <p>{{ $message->message }}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        <form class="sendMessageForm mt-4 flex items-center gap-2" method="POST" action="{{ route('chat.sendMessage') }}">
                            @csrf

                            @if($errors->any())
                                <div class="text-red-500 text-sm">{{ $errors->first() }}</div>
                            @endif

                            <input
                                class="message flex-1 px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                name="message"
                                placeholder="Type a message..."
                                required
                            >

                            <button
                                type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 transition"
                            >
                                Send
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@vite('resources/js/app.js')

