@php use App\Models\User; $users = User::all(); @endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col space-y-2">
                        @foreach($users as $user)
                            @if($user->id !== auth()->id())
                                <a
                                    href="http://127.0.0.1:8000/chat/{{$user->id}}"
                                    class="inline-block bg-blue-200 text-black text-lg font-medium py-2 px-4 rounded-lg shadow hover:bg-blue-300 transition"
                                >
                                    {{ $user->name }}
                                </a>
                            @endif
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
