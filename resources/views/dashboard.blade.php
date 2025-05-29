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
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        let message = document.querySelector('.message').value;
        let csrf = document.querySelector('input[name="_token"]').value;

        const formData = new FormData();
        formData.append('message', message);
        formData.append('_token', csrf);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            // No need to set headers for FormData — browser handles it
        })
            .then(response => response.text()) // or .json() if returning JSON
            .then(data => {
                document.querySelector('.message').value = '';
            })
            .catch(error => {
                console.error('Error:', error);
                // handle error (e.g., show error message)
            });
    });
</script>

<script type="module">
    Echo.channel('chat-room')
    .listen('MessageSent', (e) => {
        console.log(e.message);
    });
</script>
