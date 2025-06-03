@props(['message'])

@php
    $isMe = $message->sender_id === auth()->id();
@endphp

<div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
    <div class="{{ $isMe ? 'bg-blue-500 text-white' : 'bg-gray-300 text-black' }} px-4 py-2 rounded-lg max-w-xs text-sm shadow">
        <p>{{ $message->message }}</p>
    </div>
</div>
