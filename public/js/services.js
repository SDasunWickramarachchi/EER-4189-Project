const { createApp } = Vue;

createApp({
    data() {
        return {
            navLinks: [
                { label: "Home",      href: "/" },
                { label: "Portfolio", href: "/portfolio" },
                { label: "Services",  href: "/services" },
                { label: "Packages",  href: "/packages" },
                { label: "About",     href: "/about" },
                { label: "Contact",   href: "/contact" },
            ],

            services: [
                {
                    title: "Newborn & Six Months",
                    text: "Capturing the delicate first chapters of life with a minimalist and emotive approach. We focus on the pure, unscripted moments between parents and their little ones, using soft natural light to create timeless portraits that feel as gentle as a lullaby.",
                    image: "/images/service-newborn.jpg",
                    alt: "Newborn baby wrapped in a blanket",
                    band: "blue",
                    button: "btn-pink",
                    link: "/packages",
                },
                {
                    title: "Maternity",
                    text: "Celebrating the strength and grace of motherhood. Our maternity sessions are designed to be an editorial experience, focusing on elegant silhouettes and the profound emotional connection of this transformative journey.",
                    image: "/images/service-maternity.jpg",
                    alt: "Expecting mother in a flowing white gown",
                    band: "lilac",
                    button: "btn-slate",
                    link: "/packages",
                },
                {
                    title: "Events",
                    text: "Documenting life's grandest celebrations with a cinematic eye. From intimate weddings to significant milestones, we capture the atmosphere, the details, and the raw emotions that make your event unforgettable.",
                    image: "/images/service-events.jpg",
                    alt: "Guests celebrating together at an event",
                    band: "blue",
                    button: "btn-pink",
                    link: "/packages",
                },
            ],
        };
    },
}).mount("#app");
