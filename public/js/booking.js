const { createApp } = Vue;

const DEMO_MODE = true;

createApp({
    data() {
        return {
            navLinks: [
                { label: "Home", href: "/" },
                { label: "Portfolio", href: "/portfolio" },
                { label: "Services", href: "/services" },
                { label: "Packages", href: "/packages" },
                { label: "About", href: "/about" },
                { label: "Contact", href: "/contact" },
            ],

            inclusions: [
                "Pre-session consultation",
                "Print release rights",
                "High-resolution digital downloads",
            ],

            guidelines: [
                { title: "What to Bring",
                  items: ["2-3 outfit changes (neutral tones preferred)","Personal touch items or props (if desired)"] },
                { title: "Studio Etiquette",
                  items: ["Arrive 15 minutes prior to scheduled time", "Only immediate participants permitted in studio"] },
            ],

            sessionTypes: [
                "Weddings & Couples",
                "Maternity",
                "Newborn & Six Months",
                "Portraits & Lifestyle",
                "Events & Invitations",
            ],

            form: { full_name: "", phone: "", email: "", session_date: "", session_type: "", venue: "" },
            errors: {},
            sending: false,
            serverError: "",
            showThanks: false,
            sentName: "",

            today: new Date(Date.now() - new Date().getTimezoneOffset() * 60000).toISOString().slice(0, 10),
        };
    },

    methods: {
        validate() {
            const f = this.form;
            const e = {};

            if (!f.full_name) e.full_name = "Please enter your full name.";
            if (!/^[0-9+\-\s()]{7,20}$/.test(f.phone)) e.phone = "Please enter a valid phone number.";
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(f.email)) e.email = "Please enter a valid email address.";
            if (!f.session_date) e.session_date = "Please choose a date.";
            else if (f.session_date < this.today) e.session_date = "Please choose today or a later date.";
            if (!f.session_type) e.session_type = "Please select a session type.";
            if (!f.venue) e.venue = "Please enter the venue or location.";

            this.errors = e;
            return Object.keys(e).length === 0;
        },

        async submit() {
            this.serverError = "";
            if (!this.validate()) return;

            this.sending = true;
            try {
                if (DEMO_MODE) {
                    await new Promise(resolve => setTimeout(resolve, 600)); 
                    this.sentName = this.form.full_name.split(" ")[0];
                    this.showThanks = true;
                    this.form = { full_name: "", phone: "", email: "", session_date: "", session_type: "", venue: "" };
                    this.errors = {};
                    return;
                }

                const res = await fetch("/booking", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify(this.form),
                });

                if (res.status === 422) {
                    const data = await res.json();
                    const e = {};
                    for (const key in data.errors) e[key] = data.errors[key][0];
                    this.errors = e;
                    return;
                }
                if (!res.ok) throw new Error("Server responded with " + res.status);

                this.sentName = this.form.full_name.split(" ")[0];
                this.showThanks = true;
                this.form = { full_name: "", phone: "", email: "", session_date: "", session_type: "", venue: "" };
                this.errors = {};
            } catch (err) {
                this.serverError = "Sorry, something went wrong and your request was not sent. Please try again or contact us directly.";
            } finally {
                this.sending = false;
            }
        },
    },

    mounted() {
        window.addEventListener("keydown", e => { if (e.key === "Escape") this.showThanks = false; });
    },
}).mount("#app");