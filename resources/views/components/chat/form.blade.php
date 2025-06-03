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
