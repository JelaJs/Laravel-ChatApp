@props(['users'])

<div class="mb-4 space-x-2">
    @foreach($users as $user)
        @if($user->id !== auth()->id())
            <a href="{{ url('/chat/' . $user->id) }}" class="users text-blue-600 hover:underline">
                {{ $user->name }}
            </a>
        @endif
    @endforeach
</div>
