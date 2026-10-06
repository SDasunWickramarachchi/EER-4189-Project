const { createApp } = Vue;

createApp({
    data() {
        return {
            lightbox: null,          
            years: 10,

            navLinks: [
                { label: "Home",      href: "/" },
                { label: "Portfolio", href: "/portfolio" },
                { label: "Services",  href: "/services" },
                { label: "Packages",  href: "/packages" },
                { label: "About",     href: "/about" },
                { label: "Contact",   href: "/contact" },
            ],

            services: [
                { icon: "\u2665", title: "Weddings & Couples",
                  text: "Natural, timeless coverage of your big day, from preparation to the last dance.",
                  link: "/portfolio" },
                { icon: "\u273F", title: "Maternity & Newborn",
                  text: "Gentle sessions that celebrate pregnancy and the first days of a new life.",
                  link: "/portfolio" },
                { icon: "\u263A", title: "Portraits & Lifestyle",
                  text: "Relaxed portraits for individuals, families, and professionals.",
                  link: "/portfolio" },
                { icon: "\u2726", title: "Events & Invitations",
                  text: "Birthdays, celebrations, and corporate events captured as they unfold.",
                  link: "/portfolio"},
            ],

            gallery: [
                { src: "/images/gallery-1.jpg", alt: "Wedding couple" },
                { src: "/images/gallery-2.jpg", alt: "Maternity portrait" },
                { src: "/images/gallery-3.jpg", alt: "Newborn baby" },
                { src: "/images/gallery-4.jpg", alt: "Sunset portrait" },
                { src: "/images/gallery-5.jpg", alt: "Couple by the sea" },
            ],

    
            reviews: [
                { name: "Bindu Silva",
                  text: "Our wedding photos were beyond what we imagined. Ashan made everyone feel at ease." },
                { name: "Sarah Costa",
                  text: "Professional, patient, and so creative. Our newborn session was a joy." },
                { name: "Preethi Perera",
                  text: "Every photo told a story. We will be booking Ashan for every family event." },
            ],
        };
    },

    methods: {
        closeLightbox() { this.lightbox = null; },
        step(direction) {
            const total = this.gallery.length;
            this.lightbox = (this.lightbox + direction + total) % total;
        },
        onKey(e) {
            if (this.lightbox === null) return;
            if (e.key === "Escape") this.closeLightbox();
            if (e.key === "ArrowLeft") this.step(-1);
            if (e.key === "ArrowRight") this.step(1);
        },
    },

    mounted() { window.addEventListener("keydown", this.onKey); },
    unmounted() { window.removeEventListener("keydown", this.onKey); },
}).mount("#app");