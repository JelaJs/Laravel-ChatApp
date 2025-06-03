<div id="chat-container"
     data-conversation-id="{{ $conversation->conversation_id }}"
     data-user-id="{{ auth()->id() }}"
     data-receiver-id="{{ $receiver->id }}">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div id="chat-body" class="p-4 space-y-2 h-[500px] overflow-y-auto bg-gray-100 rounded-lg">
                    {{ $messages }}
                </div>

                {{ $form }}
            </div>
        </div>
    </div>
</div>
