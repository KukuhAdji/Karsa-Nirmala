@extends('layouts.app')

@section('content')

<div class="mx-auto flex min-h-[82vh] w-full max-w-5xl flex-col justify-end px-4 pb-6 pt-8 sm:px-6">

    <div id="chatMessages" class="mx-auto flex w-full max-w-4xl flex-1 flex-col gap-5 overflow-y-auto px-2 py-3"></div>

    <div class="mx-auto mt-2 w-full max-w-4xl rounded-[28px] border border-slate-200/70 bg-white/80 p-3 shadow-[0_20px_40px_rgba(15,23,42,0.06)] backdrop-blur-sm">
        <div class="flex items-center gap-3 rounded-[22px] bg-white/60 px-2 py-2">
            <div class="ml-2 flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-500 shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M9 18h6"/>
                    <path d="M10 16V8"/>
                    <path d="M14 16V8"/>
                    <path d="M5 8h14"/>
                </svg>
            </div>

            <input
                id="chatInput"
                type="text"
                placeholder="Ask, write or search for anything..."
                class="flex-1 border-0 bg-transparent px-2 py-2 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none"
            >

            <button
                id="chatSendBtn"
                class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-[#111827] text-white shadow-[0_10px_25px_rgba(17,24,39,0.25)] transition hover:scale-[1.02]"
                aria-label="Send message"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14"/>
                    <path d="m13 5 7 7-7 7"/>
                </svg>
            </button>
        </div>

        <p id="chatStatus" class="mt-2 px-2 text-xs font-medium text-slate-500">
            Chatbot terhubung ke FastAPI.
        </p>
    </div>

</div>

<script>

const FASTAPI_URL = "{{ env('FASTAPI_URL', 'http://127.0.0.1:8001') }}".replace(/\/+$/g, '');
const CHAT_ENDPOINT = `${FASTAPI_URL}/chat`;

console.log("FASTAPI_URL :", FASTAPI_URL);
console.log("CHAT_ENDPOINT :", CHAT_ENDPOINT);

const chatMessages = document.getElementById('chatMessages');
const chatInput = document.getElementById('chatInput');
const chatSendBtn = document.getElementById('chatSendBtn');
const chatStatus = document.getElementById('chatStatus');

function addChatBubble(text, sender) {
    const wrapper = document.createElement('div');
    wrapper.className = sender === 'user' ? 'flex items-end justify-end' : 'flex items-start gap-3';

    const avatar = document.createElement('div');
    avatar.className = sender === 'user'
        ? 'hidden'
        : 'mt-1 flex h-9 w-9 items-center justify-center overflow-hidden rounded-full bg-gradient-to-br from-lime-400 to-emerald-500 shadow-[0_12px_25px_rgba(34,197,94,0.28)] ring-2 ring-white';

    if (sender !== 'user') {
        avatar.innerHTML = '<img src="{{ asset('images/chatbot-avatar-peri.png') }}" alt="AI avatar" class="h-full w-full object-cover rounded-full">';
    }

    const bubble = document.createElement('div');
    bubble.className = sender === 'user'
        ? 'max-w-[28rem] rounded-[24px] rounded-br-md border border-slate-200/80 bg-white px-5 py-3 text-sm leading-relaxed text-slate-800 shadow-[0_12px_25px_rgba(15,23,42,0.06)]'
        : 'max-w-[30rem] rounded-[24px] rounded-tl-md border border-emerald-100 bg-emerald-50/80 px-4 py-3 text-sm leading-relaxed text-slate-800 shadow-[0_12px_25px_rgba(34,197,94,0.08)] backdrop-blur-sm';

    bubble.textContent = text;

    if (sender === 'user') {
        wrapper.appendChild(bubble);
    } else {
        wrapper.appendChild(avatar);
        wrapper.appendChild(bubble);
    }

    chatMessages.appendChild(wrapper);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function showTypingIndicator() {
    const typingWrapper = document.createElement('div');
    typingWrapper.className = 'flex items-start gap-3';
    typingWrapper.id = 'typingIndicator';

    const avatar = document.createElement('div');
    avatar.className = 'mt-1 flex h-9 w-9 items-center justify-center overflow-hidden rounded-full bg-gradient-to-br from-lime-400 to-emerald-500 shadow-[0_12px_25px_rgba(34,197,94,0.28)] ring-2 ring-white';
    avatar.innerHTML = '<img src="{{ asset('images/chatbot-avatar-peri.png') }}" alt="AI avatar" class="h-full w-full object-cover rounded-full">';

    const bubble = document.createElement('div');
    bubble.className = 'flex items-center gap-2 rounded-[24px] rounded-tl-md border border-emerald-100 bg-emerald-50/80 px-4 py-3 text-slate-800 shadow-[0_12px_25px_rgba(34,197,94,0.08)]';

    bubble.innerHTML = `
        <span class="h-2.5 w-2.5 animate-bounce rounded-full bg-emerald-500 [animation-delay:-0.2s]"></span>
        <span class="h-2.5 w-2.5 animate-bounce rounded-full bg-emerald-500 [animation-delay:-0.1s]"></span>
        <span class="h-2.5 w-2.5 animate-bounce rounded-full bg-emerald-500"></span>
    `;

    typingWrapper.appendChild(avatar);
    typingWrapper.appendChild(bubble);
    chatMessages.appendChild(typingWrapper);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function removeTypingIndicator() {
    const indicator = document.getElementById('typingIndicator');
    if (indicator) indicator.remove();
}

async function sendChat() {
    const message = chatInput.value.trim();
    if (message === '') return;

    addChatBubble(message, 'user');
    chatInput.value = '';
    chatStatus.textContent = 'Menghubungi FastAPI...';
    showTypingIndicator();
    chatSendBtn.disabled = true;
    chatSendBtn.classList.add('opacity-60', 'cursor-not-allowed');

    try {
        const response = await fetch(CHAT_ENDPOINT, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ message: message })
        });

        const raw = await response.text();
        let data;

        try {
            data = JSON.parse(raw);
        } catch (e) {
            throw new Error('Response bukan JSON : ' + raw);
        }

        if (!response.ok) {
            throw new Error(data.detail ?? data.message ?? 'FastAPI Error');
        }

        removeTypingIndicator();
        addChatBubble(data.reply ?? 'Tidak ada balasan.', 'bot');
        chatStatus.textContent = 'Balasan diterima.';

    } catch (error) {
        console.error(error);
        removeTypingIndicator();
        addChatBubble(error.message, 'bot');
        chatStatus.textContent = error.message;
    } finally {
        chatSendBtn.disabled = false;
        chatSendBtn.classList.remove('opacity-60', 'cursor-not-allowed');
    }
}

chatSendBtn.addEventListener('click', sendChat);

chatInput.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        sendChat();
    }
});

</script>

@endsection