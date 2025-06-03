import './bootstrap';

import { initChat } from './chat';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const chatContainer = document.getElementById('chat-container');
    if (chatContainer) {
        const conversationId = chatContainer.dataset.conversationId;
        const userId = parseInt(chatContainer.dataset.userId);
        const receiverId = parseInt(chatContainer.dataset.receiverId);
        initChat(conversationId, userId, receiverId);
    }
});
