const { createApp } = Vue;

const SLOT_TIMES = {
    Morning: { start_time: "09:00 AM", end_time: "01:00 PM" },
    Golden:  { start_time: "02:30 PM", end_time: "06:30 PM" },
};

const emptyForm = () => ({
    full_name: "", phone: "", email: "",
    session_date: "", session_type: "", venue: "", slot: "",
});

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
                  items: ["2-3 outfit changes (neutral tones preferred)", "Personal touch items or props (if desired)"] },
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

            form: emptyForm(),
            errors: {},
            sending: false,
            serverError: "",
            showThanks: false,
            sentName: "",
            reference: "",

            checking: false,
            availabilityMessage: "",
            dateAvailable: true,
            slots: [],
            checkId: 0,

            today: new Date(Date.now() - new Date().getTimezoneOffset() * 60000).toISOString().slice(0, 10),
        };
    },

    watch: {
        "form.session_date"(date) {
            if (date) this.checkDate();
            else this.clearAvailability();
        },
    },

    methods: {
        clearAvailability() {
            this.slots = [];
            this.form.slot = "";
            this.availabilityMessage = "";
            this.dateAvailable = true;
            this.checking = false;
        },

        async checkDate() {
            const date = this.form.session_date;
            if (date < this.today) { this.clearAvailability(); return; }

            const id = ++this.checkId;          
            this.slots = [];
            this.form.slot = "";
            this.availabilityMessage = "";
            this.checking = true;

            try {
                const res = await fetch("/api/bookings/availability?date=" + encodeURIComponent(date), {
                    headers: { Accept: "application/json" },
                });
                const data = await res.json().catch(() => ({}));
                if (id !== this.checkId) return;

                if (!res.ok || data.status !== "success") {
                    this.availabilityMessage = "We could not check availability right now. You can still send your request.";
                    this.dateAvailable = true;
                    return;
                }

                this.slots = data.slots || [];
                this.dateAvailable = !!data.available;
                this.availabilityMessage = data.available
                    ? data.message
                    : "This date is fully booked. Choose another date, or send your request and we will review it manually.";
            } catch (err) {
                if (id !== this.checkId) return;
                this.availabilityMessage = "We could not check availability right now. You can still send your request.";
                this.dateAvailable = true;
            } finally {
                if (id === this.checkId) this.checking = false;
            }
        },

        timesFor(slotLabel) {
            const slot = this.slots.find(s => s.slot === slotLabel);
            if (!slot) return null;
            if (slot.start_time && slot.end_time) {
                return { start_time: slot.start_time, end_time: slot.end_time };
            }
            const key = Object.keys(SLOT_TIMES).find(k => slotLabel.startsWith(k));
            return key ? SLOT_TIMES[key] : null;
        },

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
            if (this.slots.some(s => s.available) && !f.slot) e.slot = "Please choose a session slot.";

            this.errors = e;
            return Object.keys(e).length === 0;
        },

        async submit() {
            this.serverError = "";
            if (!this.validate()) return;

            const f = this.form;
            const payload = {
                client_name: f.full_name,
                client_phone: f.phone,
                client_email: f.email,
                session_date: f.session_date,
                session_type: f.session_type,
                location: f.venue,
            };
            const times = f.slot ? this.timesFor(f.slot) : null;
            if (times) Object.assign(payload, times);

            this.sending = true;
            try {
                const meta = document.querySelector('meta[name="csrf-token"]');
                const res = await fetch("/api/bookings", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": meta ? meta.content : "",
                    },
                    body: JSON.stringify(payload),
                });
                const data = await res.json().catch(() => ({}));

                if (res.status === 422 && data.errors) {
                    const map = { client_name: "full_name", client_phone: "phone", client_email: "email", location: "venue" };
                    const e = {};
                    for (const key in data.errors) e[map[key] || key] = data.errors[key][0];
                    this.errors = e;
                    return;
                }
                if (res.status === 419) {
                    this.serverError = "Your session expired. Please refresh the page and try again.";
                    return;
                }
                if (!res.ok || data.status !== "success") {
                    throw new Error(data.message || "Server responded with " + res.status);
                }

                this.reference = (data.confirmation && data.confirmation.reference_number) || "";
                this.sentName = f.full_name.split(" ")[0];
                this.showThanks = true;
                this.form = emptyForm();
                this.errors = {};
                this.clearAvailability();
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