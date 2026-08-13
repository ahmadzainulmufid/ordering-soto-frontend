<!DOCTYPE html>

<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'Soto Lamongan Joko Tingkir')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary-container": "#ffc107",
                        "inverse-on-surface": "#fbefde",
                        "on-tertiary": "#ffffff",
                        "tertiary-container": "#ffbab3",
                        "surface-container": "#f8ecdb",
                        "surface-container-high": "#f2e7d6",
                        "on-primary-fixed-variant": "#5b4300",
                        "surface-variant": "#ece1d0",
                        "surface-tint": "#785900",
                        "primary": "#785900",
                        "surface-container-highest": "#ece1d0",
                        "secondary-fixed-dim": "#91d78a",
                        "on-background": "#201b11",
                        "tertiary": "#ba1a20",
                        "surface-container-lowest": "#ffffff",
                        "outline": "#827660",
                        "surface-dim": "#e4d9c8",
                        "inverse-primary": "#fabd00",
                        "on-secondary-container": "#307231",
                        "on-primary-container": "#6d5100",
                        "on-secondary-fixed": "#002203",
                        "on-tertiary-container": "#ac0c18",
                        "outline-variant": "#d4c5ab",
                        "on-error": "#ffffff",
                        "on-error-container": "#93000a",
                        "on-tertiary-fixed-variant": "#930010",
                        "on-tertiary-fixed": "#410003",
                        "inverse-surface": "#363024",
                        "error-container": "#ffdad6",
                        "surface-container-low": "#fef2e1",
                        "surface": "#fff8f2",
                        "on-primary-fixed": "#261a00",
                        "on-surface-variant": "#4f4632",
                        "on-secondary": "#ffffff",
                        "on-secondary-fixed-variant": "#0c5216",
                        "primary-fixed-dim": "#fabd00",
                        "on-primary": "#ffffff",
                        "surface-bright": "#fff8f2",
                        "secondary-fixed": "#acf4a4",
                        "tertiary-fixed-dim": "#ffb3ac",
                        "secondary": "#2a6b2c",
                        "on-surface": "#201b11",
                        "secondary-container": "#acf4a4",
                        "primary-fixed": "#ffdf9e",
                        "tertiary-fixed": "#ffdad6",
                        "error": "#ba1a1a",
                        "background": "#fff8f2"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "base": "4px",
                        "margin-mobile": "20px",
                        "margin-desktop": "64px",
                        "gutter": "24px",
                        "column-count": "12"
                    },
                    "fontFamily": {
                        "label-md": ["Rubik"],
                        "title-md": ["Rubik"],
                        "body-lg": ["Rubik"],
                        "headline-lg-mobile": ["Rubik"],
                        "label-sm": ["Rubik"],
                        "headline-lg": ["Rubik"],
                        "display-lg": ["Rubik"],
                        "body-md": ["Rubik"]
                    },
                    "fontSize": {
                        "label-md": ["14px", {
                            "lineHeight": "20px",
                            "letterSpacing": "0.01em",
                            "fontWeight": "500"
                        }],
                        "title-md": ["20px", {
                            "lineHeight": "28px",
                            "fontWeight": "500"
                        }],
                        "body-lg": ["18px", {
                            "lineHeight": "28px",
                            "fontWeight": "400"
                        }],
                        "headline-lg-mobile": ["24px", {
                            "lineHeight": "32px",
                            "fontWeight": "600"
                        }],
                        "label-sm": ["12px", {
                            "lineHeight": "16px",
                            "fontWeight": "600"
                        }],
                        "headline-lg": ["32px", {
                            "lineHeight": "40px",
                            "fontWeight": "600"
                        }],
                        "display-lg": ["48px", {
                            "lineHeight": "56px",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "700"
                        }],
                        "body-md": ["16px", {
                            "lineHeight": "24px",
                            "fontWeight": "400"
                        }]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .active-nav-item {
            color: #6d5100;
            border-bottom: 2px solid #6d5100;
            padding-bottom: 4px;
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>

<body class="bg-background text-on-background font-body-md">

    {{-- Panggil Navbar --}}
    @include('includes.navbar')

    {{-- Tempat Konten Utama --}}
    <main class="max-w-360 mx-auto overflow-x-hidden">
        @yield('content')
    </main>

    {{-- Panggil Footer --}}
    @include('includes.footer')


    <script>
        // Micro-interactions and effects
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('mousedown', () => {
                button.classList.add('scale-95');
            });
            button.addEventListener('mouseup', () => {
                button.classList.remove('scale-95');
            });
            button.addEventListener('mouseleave', () => {
                button.classList.remove('scale-95');
            });
        });

        // Sticky Navbar shadow on scroll
        window.addEventListener('scroll', () => {
            const navs = document.querySelectorAll('nav');
            if (window.scrollY > 20) {
                navs.forEach(nav => nav.classList.add('shadow-lg'));
            } else {
                navs.forEach(nav => nav.classList.remove('shadow-lg'));
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            const navLinks = document.querySelectorAll('.nav-link');
            const sections = document.querySelectorAll('section[id]');

            function setActiveLink(activeLink) {
                navLinks.forEach(link => {
                    link.classList.remove('text-primary-container', 'border-b-2',
                        'border-primary-container');
                    link.classList.add('text-on-secondary');
                });

                if (activeLink) {
                    activeLink.classList.remove('text-on-secondary');
                    activeLink.classList.add('text-primary-container', 'border-b-2', 'border-primary-container');
                }
            }

            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    setActiveLink(this);
                });
            });

            const observerOptions = {
                root: null,
                rootMargin: '-20% 0px -60% 0px',
                threshold: 0
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const id = entry.target.getAttribute('id');
                        const matchingLink = document.querySelector(`.nav-link[data-nav="${id}"]`);
                        if (matchingLink) {
                            setActiveLink(matchingLink);
                        }
                    }
                });

                if (window.scrollY < 200) {
                    const homeLink = document.querySelector('.nav-link[data-nav="hero"]');
                    if (homeLink) setActiveLink(homeLink);
                }
            }, observerOptions);

            sections.forEach(section => observer.observe(section));

            window.addEventListener('scroll', () => {
                if (window.scrollY < 200) {
                    const homeLink = document.querySelector('.nav-link[data-nav="hero"]');
                    if (homeLink) setActiveLink(homeLink);
                }
            });

            if (window.location.hash) {
                setTimeout(() => {
                    history.replaceState(null, null, window.location.pathname + window.location.search);
                }, 100);
            }
        });
    </script>
</body>

</html>
