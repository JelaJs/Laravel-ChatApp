@php
    use App\Models\User;
    $users = User::all();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <x-chat.user-list :users="$users" />

        <x-chat.layout :conversation="$conversation" :receiver="$receive_user">
            <x-slot name="messages">
                @foreach($conversation->messages as $message)
                    <x-chat.message :message="$message" />
                @endforeach
            </x-slot>

            <x-slot name="form">
                <x-chat.form />
            </x-slot>
        </x-chat.layout>
    </div>
</x-app-layout>


@vite('resources/js/app.js')

