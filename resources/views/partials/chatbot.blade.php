@verbatim
<div id="chatbot" class="chatbot">

    <div class="chat-panel" v-if="open" role="dialog" aria-label="Chat assistant">
        <div class="chat-header">
            <div>
                <strong>Ashan Rumaiz Photography</strong>
                <span>Ask us anything</span>
            </div>
            <button class="chat-close" @click="open = false" aria-label="Close chat">&times;</button>
        </div>

        <div class="chat-messages" ref="messages">
            <div class="msg" v-for="(m, i) in messages" :key="i" :class="m.from">
                <p>{{ m.text }}</p>
                <a v-if="m.link" :href="m.link.href" class="msg-link">{{ m.link.label }}</a>
            </div>
        </div>

        <div class="chat-chips">
            <button v-for="q in quickQuestions" :key="q" @click="ask(q)">{{ q }}</button>
        </div>

        <div class="chat-input">
            <input type="text" v-model="draft" @keydown.enter="send"
                   placeholder="Type your question..." aria-label="Your message">
            <button @click="send">Send</button>
        </div>
    </div>

    <button class="chat-fab" @click="toggle" :aria-expanded="open" aria-label="Open chat assistant">
        <svg viewBox="0 0 26 26" width="30" height="30" fill="currentColor" aria-hidden="true">
            <circle cx="10" cy="3" r="1.4"/>
            <rect x="9.4" y="3.5" width="1.2" height="2.5"/>
            <rect x="3" y="6" width="14" height="10" rx="3.5"/>
            <circle class="eye" cx="7.5" cy="11" r="1.5"/>
            <circle class="eye" cx="12.5" cy="11" r="1.5"/>
            <rect x="5" y="17.5" width="10" height="5" rx="2.5"/>
            <path d="M20 11l1.3 3.4 3.4 1.3-3.4 1.3L20 20.4l-1.3-3.4-3.4-1.3 3.4-1.3z"/>
        </svg>
    </button>
</div>
@endverbatim


