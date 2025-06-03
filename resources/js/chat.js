function sendMessage(form, receiverId) {
    const messageInput = form.querySelector('.message');
    const message = messageInput.value.trim();
    const csrf = form.querySelector('input[name="_token"]').value;

    if (!message) return;

    const formData = new FormData();
    formData.append('message', message);
    formData.append('receiver_id', receiverId);
    formData.append('_token', csrf);

    fetch(form.action, {
        method: 'POST',
        body: formData,
    })
        .then(() => {
            messageInput.value = '';
        })
        .catch(console.error);
}

function createMessageHTML(message, isSender) {
    const baseClasses = "px-4 py-2 rounded-lg max-w-xs text-sm shadow";
    if (isSender) {
        return `<div class="flex justify-end">
                    <div class="bg-blue-500 text-white ${baseClasses}">
                        <p>${message}</p>
                    </div>
                </div>`;
    } else {
        return `<div class="flex justify-start">
                    <div class="bg-gray-300 text-black ${baseClasses}">
                        <p>${message}</p>
                    </div>
                </div>`;
    }
}

function listenForMessages(conversationId, userId, chatBody) {
    Echo.channel(conversationId)
        .listen('MessageSent', (e) => {
            if (!e.message) return;

            const isSender = e.sender_id === userId;
            const html = createMessageHTML(e.message, isSender);

            chatBody.insertAdjacentHTML("beforeend", html);
            chatBody.scrollTop = chatBody.scrollHeight;
        });
}

export function initChat(conversationId, userId, receiverId) {
    const form = document.querySelector('.sendMessageForm');
    const chatBody = document.querySelector('#chat-body');

    if (!form || !chatBody) return;

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        sendMessage(form, receiverId);
    });

    listenForMessages(conversationId, userId, chatBody);
}
