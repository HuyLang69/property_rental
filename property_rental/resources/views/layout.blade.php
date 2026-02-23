<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'NestAway — Find Your Place')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink:    '#111111',
                        carbon: '#2a2a2a',
                        slate:  '#5c5c5c',
                        silver: '#a8a8a8',
                        fog:    '#e4e2de',
                        cream:  '#f6f4f0',
                    },
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Jost', sans-serif; }
        .font-display { font-family: 'Cormorant Garamond', serif; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f6f4f0; }
        ::-webkit-scrollbar-thumb { background: #c0beba; border-radius: 999px; }
        .nav-link { position: relative; padding-bottom: 2px; }
        .nav-link::after { content:''; position:absolute; left:0; bottom:0; height:1px; width:0; background:#111; transition:width 0.24s ease; }
        .nav-link:hover::after { width: 100%; }
        .lift { transition: transform 0.28s ease, box-shadow 0.28s ease; }
        .lift:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,0.11); }
        .img-zoom { overflow: hidden; }
        .img-zoom img { transition: transform 0.5s ease; }
        .img-zoom:hover img { transform: scale(1.06); }
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(20px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .fade-up { animation: fadeUp 0.55s ease both; }
        .d1 { animation-delay: 0.05s; }
        .d2 { animation-delay: 0.15s; }
        .d3 { animation-delay: 0.25s; }
        .d4 { animation-delay: 0.35s; }
        .d5 { animation-delay: 0.45s; }
    </style>

    @yield('head')
</head>

<body class="bg-cream text-ink min-h-screen flex flex-col antialiased">

    {{-- HEADER --}}
    <header class="fixed top-0 inset-x-0 z-50 bg-cream/85 backdrop-blur-md border-b border-fog">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-4">

                <a href="{{ url('/') }}" class="flex items-baseline gap-0.5 shrink-0 group">
                    <span class="font-display text-[1.7rem] font-bold tracking-tight text-ink leading-none">NestAway</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-ink mb-0.5 group-hover:scale-150 transition-transform duration-200 inline-block"></span>
                </a>

                {{-- DYNAMIC: form action points to your listings search route --}}
                <form action="{{ url('/listings') }}" method="GET"
                      class="hidden md:flex items-center flex-1 max-w-sm mx-4 bg-white border border-fog rounded-full px-4 py-2 gap-2 shadow-sm hover:shadow-md transition-shadow">
                    <svg class="w-4 h-4 text-silver shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                    </svg>
                    <input autocomplete="off" type="text" name="search" placeholder="City, neighbourhood…"
                           class="flex-1 bg-transparent text-sm text-ink placeholder-silver outline-none min-w-0" />
                    <button type="submit" class="bg-ink text-white text-xs font-semibold rounded-full px-3 py-1 hover:bg-carbon transition-colors shrink-0">
                        Go
                    </button>
                </form>

                <nav class="hidden md:flex items-center gap-7 text-sm font-medium text-slate">
                    <a href="{{ url('/listings') }}" class="nav-link hover:text-ink transition-colors">Browse</a>
                    <a href="{{ url('/host') }}"     class="nav-link hover:text-ink transition-colors">Host</a>
                    <div class="w-px h-4 bg-fog mx-1"></div>

                    {{-- DYNAMIC: replace with @auth / @guest when auth is set up --}}
                    <a href="{{ url('/login') }}" class="hover:text-ink transition-colors">Log in</a>
                    <a href="{{ url('/register') }}" class="bg-ink text-white rounded-full px-5 py-2 text-sm font-medium hover:bg-carbon transition-colors">
                        Sign up
                    </a>
                </nav>

                <button id="mob-toggle" class="md:hidden p-2 rounded-lg hover:bg-fog transition-colors" aria-label="Menu">
                    <svg id="ic-open"  class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg id="ic-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <div id="mob-menu" class="hidden md:hidden border-t border-fog bg-cream px-4 py-5 flex flex-col gap-4">
            <form action="{{ url('/listings') }}" method="GET"
                  class="flex items-center bg-white border border-fog rounded-full px-4 py-2 gap-2">
                <svg class="w-4 h-4 text-silver shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                </svg>
                <input autocomplete="off" type="text" name="search" placeholder="Search…" class="flex-1 bg-transparent text-sm placeholder-silver outline-none" />
            </form>
            <nav class="flex flex-col gap-3 text-sm font-medium text-slate">
                <a href="{{ url('/listings') }}" class="hover:text-ink py-1 transition-colors">Browse</a>
                <a href="{{ url('/host') }}"     class="hover:text-ink py-1 transition-colors">Host</a>
            </nav>
            <div class="flex gap-2">
                <a href="{{ url('/login') }}"    class="flex-1 text-center border border-fog rounded-full py-2 text-sm font-medium hover:border-silver transition-colors">Log in</a>
                <a href="{{ url('/register') }}" class="flex-1 text-center bg-ink text-white rounded-full py-2 text-sm font-medium hover:bg-carbon transition-colors">Sign up</a>
            </div>
        </div>
    </header>

    <main class="flex-1 pt-16">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-ink text-white mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-10 pb-10 border-b border-carbon">

                <div class="col-span-2 lg:col-span-1">
                    <span class="font-display text-2xl font-bold tracking-tight">NestAway</span>
                    <p class="mt-3 text-sm text-silver leading-relaxed">
                        Unique places to stay, hosted by people who care.
                    </p>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-widest text-silver mb-4">Explore</p>
                    <ul class="space-y-2.5 text-sm text-silver">
                        {{-- DYNAMIC: link to filtered listing routes --}}
                        <li><a href="{{ url('/listings') }}"                class="hover:text-white transition-colors">All Listings</a></li>
                        <li><a href="{{ url('/listings?type=apartment') }}" class="hover:text-white transition-colors">Apartments</a></li>
                        <li><a href="{{ url('/listings?type=house') }}"     class="hover:text-white transition-colors">Houses</a></li>
                        <li><a href="{{ url('/listings?type=studio') }}"    class="hover:text-white transition-colors">Studios</a></li>
                        <li><a href="{{ url('/listings?type=villa') }}"     class="hover:text-white transition-colors">Villas</a></li>
                    </ul>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-widest text-silver mb-4">Hosting</p>
                    <ul class="space-y-2.5 text-sm text-silver">
                        <li><a href="{{ url('/host') }}"           class="hover:text-white transition-colors">Become a Host</a></li>
                        <li><a href="{{ url('/host/resources') }}" class="hover:text-white transition-colors">Resources</a></li>
                        <li><a href="{{ url('/host/dashboard') }}" class="hover:text-white transition-colors">Dashboard</a></li>
                    </ul>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-widest text-silver mb-4">Company</p>
                    <ul class="space-y-2.5 text-sm text-silver">
                        <li><a href="{{ url('/about') }}"   class="hover:text-white transition-colors">About</a></li>
                        <li><a href="{{ url('/contact') }}" class="hover:text-white transition-colors">Contact</a></li>
                        <li><a href="{{ url('/privacy') }}" class="hover:text-white transition-colors">Privacy</a></li>
                        <li><a href="{{ url('/terms') }}"   class="hover:text-white transition-colors">Terms</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-silver">
                <p>&copy; {{ date('Y') }} NestAway. All rights reserved.</p>
                <p class="text-carbon">College project &mdash; not for commercial use.</p>
            </div>
        </div>
    </footer>

    <script>
        const mobToggle = document.getElementById('mob-toggle');
        const mobMenu   = document.getElementById('mob-menu');
        const icOpen    = document.getElementById('ic-open');
        const icClose   = document.getElementById('ic-close');
        mobToggle.addEventListener('click', () => {
            const isOpen = !mobMenu.classList.contains('hidden');
            mobMenu.classList.toggle('hidden', isOpen);
            icOpen.classList.toggle('hidden', !isOpen);
            icClose.classList.toggle('hidden', isOpen);
        });
    </script>

    @yield('scripts')
</body>
</html>