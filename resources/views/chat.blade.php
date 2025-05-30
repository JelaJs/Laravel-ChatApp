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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div id="chat-body">
                        @if($chat)
                            @foreach($chat as $message)
                                @if($message->sender_id == auth()->id())
                                    <div style="color:blue">
                                        <p>{{$message->message}}</p>
                                    </div>
                                @else
                                    <div style="color:red">
                                        <p>{{$message->message}}</p>
                                    </div>
                                @endif

                            @endforeach
                        @endif
                    </div>
                    <form class="sendMessageForm" method="POST" action="{{route('chat.sendMessage')}}">
                        @csrf
                        @if($errors->any())
                            {{$errors->first}}
                        @endif

                        <input class="message" name="message" placeholder="type message...">
                        <button>Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@vite('resources/js/app.js')

<script type="module">
    const form = document.querySelector('.sendMessageForm');
    let receiver_id = {{$receive_user->id}};
    console.log("{{$conversation_id}}");
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        let message = document.querySelector('.message').value;
        let csrf = document.querySelector('input[name="_token"]').value;

        const formData = new FormData();
        formData.append('message', message);
        formData.append('receiver_id', receiver_id);
        formData.append('_token', csrf);

        fetch(form.action, {
            method: 'POST',
            body: formData,
        })
            .then(response => response.text())
            .then(data => {
                document.querySelector('.message').value = '';
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>

<script type="module">
    Echo.channel("{{$conversation_id}}")
        .listen('MessageSent', (e) => {

            if(e.message !== null) {
                let user_id = {{auth()->id()}};

                if(e.sender_id == user_id) {
                    console.log('prvi uslov proso');
                    document.querySelector('#chat-body').insertAdjacentHTML("beforeend", `
                   <div style="color:blue">
                        <p>${e.message}</p>
                   </div>
                `);
                }

                if(parseInt(e.receiver_id) == user_id) {
                    console.log('drugi uslov proso');
                    document.querySelector('#chat-body').insertAdjacentHTML("beforeend", `
                   <div style="color:red">
                        <p>${e.message}</p>
                   </div>
                `);
                }
            }

        });
</script>
