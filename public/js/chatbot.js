const { createApp: createChatApp } = Vue;

const CONTACT = {
    phone: "+94 77 949 0255",
    email: "ashanrumaiz@gmail.com",
    place: "Negombo, Sri Lanka",
};

createChatApp({
    data() {
        return {
            open: false,
            draft: "",
            messages: [
                { from: "bot", text: "Hi! I'm the Ashan Rumaiz Photography assistant. How can I help you today?" },
            ],

            quickQuestions: ["What services do you offer?", "How do I book?", "How can I contact you?"],

            replies: [
                {
                    keys: ["service", "offer", "what do you", "shoot"],
                    text: "We photograph weddings and couples, maternity and newborn sessions, portraits and lifestyle, and events and invitations.",
                    link: { label: "See our services", href: "/services" },
                },
                {
                    keys: ["wedding", "couple"],
                    text: "We cover weddings and couples with natural, timeless photos, from the preparation to the last dance.",
                    link: { label: "View the portfolio", href: "/portfolio" },
                },
                {
                    keys: ["maternity", "newborn", "baby", "pregnan"],
                    text: "Our maternity and newborn sessions are gentle and relaxed, using soft natural light to create timeless portraits.",
                    link: { label: "See our services", href: "/services" },
                },
                {
                    keys: ["event", "birthday", "party", "invitation"],
                    text: "We photograph birthdays, celebrations and corporate events, capturing the atmosphere and the details as they unfold.",
                    link: { label: "See our services", href: "/services" },
                },
                {
                    keys: ["price", "cost", "package", "rate", "how much", "charge"],
                    text: "Pricing depends on the type of session. Please send an inquiry to get the full details of the package that suits you.",
                    link: { label: "View packages", href: "/packages" },
                },
                {
                    keys: ["book", "deposit", "payment", "pay", "reserve", "date"],
                    text: "A 50% non-refundable deposit is required to secure your date. The remaining balance is due before the final photos are delivered.",
                    link: { label: "Book now", href: "/booking" },
                },
                {
                    keys: ["contact", "phone", "call", "email", "number", "reach"],
                    text: `You can reach us on ${CONTACT.phone} or at ${CONTACT.email}.`,
                    link: { label: "Contact page", href: "/contact" },
                },
                {
                    keys: ["where", "location", "address", "sri lanka", "colombo", "travel"],
                    text: `We are based in ${CONTACT.place}.`,
                },
                {
                    keys: ["about", "who", "experience", "years"],
                    text: "Ashan Rumaiz Photography has spent over ten years telling real stories through photos across Sri Lanka.",
                    link: { label: "Read the story", href: "/about" },
                },
                {
                    keys: ["thank"],
                    text: "You're welcome! Let me know if there is anything else I can help with.",
                },
            ],

            greeting: "Hello! What would you like to know about our photography?",
            fallback: {
                text: "I'm not sure about that one. You can ask about our services, booking or contact details, or send us a message and we will reply.",
                link: { label: "Contact us", href: "/contact" },
            },
        };
    },

    methods: {
        toggle() { this.open = !this.open; },

        ask(question) {
            this.draft = question;
            this.send();
        },

        send() {
            const text = this.draft.trim();
            if (!text) return;

            this.messages.push({ from: "user", text });
            this.draft = "";
            this.scrollDown();

            const reply = this.findReply(text);
            setTimeout(() => {
                this.messages.push({ from: "bot", ...reply });
                this.scrollDown();
            }, 400);
        },

        findReply(text) {
            const t = text.toLowerCase();

            if (/\b(hi|hello|hey)\b/.test(t)) return { text: this.greeting };

            for (const r of this.replies) {
                if (r.keys.some(k => t.includes(k))) return { text: r.text, link: r.link };
            }
            return this.fallback;
        },

        scrollDown() {
            this.$nextTick(() => {
                const el = this.$refs.messages;
                if (el) el.scrollTop = el.scrollHeight;
            });
        },
    },
}).mount("#chatbot");