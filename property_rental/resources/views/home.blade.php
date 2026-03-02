@extends('layout')

@section('title', 'NestAway — Find Your Perfect Stay')

@section('content')

{{-- ============================================================
     HERO
============================================================ --}}
<section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden bg-ink">

    <div class="absolute inset-0 grid grid-cols-3 opacity-25 pointer-events-none">
        <div class="col-span-2 bg-cover bg-center" style="background-image:url('https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=900&q=80')"></div>
        <div class="flex flex-col">
            <div class="flex-1 bg-cover bg-center" style="background-image:url('https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=500&q=80')"></div>
            <div class="flex-1 bg-cover bg-center" style="background-image:url('https://images.unsplash.com/photo-1493809842364-78817add7ffb?w=500&q=80')"></div>
        </div>
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-ink/70 via-ink/50 to-ink/85"></div>

    <div class="relative z-10 text-center text-white px-4 sm:px-6 max-w-4xl mx-auto py-20">

        <p class="fade-up d1 text-xs uppercase tracking-[0.3em] text-silver mb-6 font-medium">Property Rentals, Reimagined</p>

        <h1 class="fade-up d2 font-display text-white leading-[1.05] mb-6 tracking-tight" style="font-size:clamp(3rem,8vw,6rem);">
            Find a place <em>you'll love</em> to stay.
        </h1>

        <p class="fade-up d3 text-silver text-base sm:text-lg font-light max-w-xl mx-auto mb-10 leading-relaxed">
            Thousands of unique homes, apartments, and studios — ready for your next stay.
        </p>

        <form action="{{ route('listings.index') }}" method="GET"
              class="fade-up d4 bg-white rounded-2xl shadow-2xl p-2 flex flex-col sm:flex-row items-stretch gap-2 max-w-2xl mx-auto">

            <div class="flex items-center gap-3 flex-1 px-4 py-2">
                <svg class="w-4 h-4 text-silver shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <input autocomplete="off" type="text" name="search" placeholder="Where are you going?"
                       class="text-sm text-ink placeholder-silver outline-none w-full bg-transparent" />
            </div>

            <div class="hidden sm:block w-px bg-fog self-stretch"></div>

            <div class="flex items-center gap-3 px-4 py-2">
                <svg class="w-4 h-4 text-silver shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                <input autocomplete="off" type="date" name="check_in" class="text-sm text-ink outline-none bg-transparent w-32 cursor-pointer" />
            </div>

            <div class="hidden sm:block w-px bg-fog self-stretch"></div>

            <div class="flex items-center gap-3 px-4 py-2">
                <svg class="w-4 h-4 text-silver shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                <input autocomplete="off" type="date" name="check_out" class="text-sm text-ink outline-none bg-transparent w-32 cursor-pointer" />
            </div>

            <button type="submit" class="bg-ink text-white font-semibold text-sm rounded-xl px-6 py-3 hover:bg-carbon transition-colors shrink-0">
                Search
            </button>
        </form>

        <div class="fade-up d5 flex flex-wrap justify-center gap-2 mt-6">
            <a href="{{ route('listings.index', ['search' => 'Lisbon']) }}"  class="text-xs text-silver border border-white/20 rounded-full px-3 py-1 hover:bg-white/10 transition-colors">Lisbon</a>
            <a href="{{ route('listings.index', ['search' => 'Porto']) }}"   class="text-xs text-silver border border-white/20 rounded-full px-3 py-1 hover:bg-white/10 transition-colors">Porto</a>
            <a href="{{ route('listings.index', ['search' => 'Lagos']) }}"   class="text-xs text-silver border border-white/20 rounded-full px-3 py-1 hover:bg-white/10 transition-colors">Lagos</a>
            <a href="{{ route('listings.index', ['search' => 'Sintra']) }}"  class="text-xs text-silver border border-white/20 rounded-full px-3 py-1 hover:bg-white/10 transition-colors">Sintra</a>
            <a href="{{ route('listings.index', ['search' => 'Cascais']) }}" class="text-xs text-silver border border-white/20 rounded-full px-3 py-1 hover:bg-white/10 transition-colors">Cascais</a>
        </div>
    </div>

    <a href="#categories" class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce text-silver/60 hover:text-silver transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
    </a>
</section>


{{-- ============================================================
     CATEGORIES
============================================================ --}}
<section id="categories" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="text-xs uppercase tracking-widest text-silver mb-1">Browse by type</p>
            <h2 class="font-display text-3xl sm:text-4xl font-bold tracking-tight">What kind of stay?</h2>
        </div>
        <a href="{{ route('listings.index') }}" class="hidden sm:flex items-center gap-1 text-sm font-medium text-slate hover:text-ink transition-colors">
            View all <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6"/></svg>
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">

        <a href="{{ route('listings.index', ['type' => 'apartment']) }}" class="lift group flex flex-col items-center justify-center gap-3 bg-white border border-fog rounded-2xl py-7 px-4 text-center hover:border-ink transition-colors">
            <div class="w-11 h-11 rounded-full bg-cream group-hover:bg-ink flex items-center justify-center transition-colors">
                <svg class="w-5 h-5 text-ink group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4v-5a1 1 0 011-1h4a1 1 0 011 1v5h4a1 1 0 001-1V10"/>
                </svg>
            </div>
            <span class="text-sm font-medium">Apartment</span>
        </a>

        <a href="{{ route('listings.index', ['type' => 'house']) }}" class="lift group flex flex-col items-center justify-center gap-3 bg-white border border-fog rounded-2xl py-7 px-4 text-center hover:border-ink transition-colors">
            <div class="w-11 h-11 rounded-full bg-cream group-hover:bg-ink flex items-center justify-center transition-colors">
                <svg class="w-5 h-5 text-ink group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 012.092 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75"/>
                </svg>
            </div>
            <span class="text-sm font-medium">House</span>
        </a>

        <a href="{{ route('listings.index', ['type' => 'studio']) }}" class="lift group flex flex-col items-center justify-center gap-3 bg-white border border-fog rounded-2xl py-7 px-4 text-center hover:border-ink transition-colors">
            <div class="w-11 h-11 rounded-full bg-cream group-hover:bg-ink flex items-center justify-center transition-colors">
                <svg class="w-5 h-5 text-ink group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 018.25 20.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25A2.25 2.25 0 0113.5 8.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
                </svg>
            </div>
            <span class="text-sm font-medium">Studio</span>
        </a>

        <a href="{{ route('listings.index', ['type' => 'villa']) }}" class="lift group flex flex-col items-center justify-center gap-3 bg-white border border-fog rounded-2xl py-7 px-4 text-center hover:border-ink transition-colors">
            <div class="w-11 h-11 rounded-full bg-cream group-hover:bg-ink flex items-center justify-center transition-colors">
                <svg class="w-5 h-5 text-ink group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819"/>
                </svg>
            </div>
            <span class="text-sm font-medium">Villa</span>
        </a>

        <a href="{{ route('listings.index', ['type' => 'room']) }}" class="lift group flex flex-col items-center justify-center gap-3 bg-white border border-fog rounded-2xl py-7 px-4 text-center hover:border-ink transition-colors">
            <div class="w-11 h-11 rounded-full bg-cream group-hover:bg-ink flex items-center justify-center transition-colors">
                <svg class="w-5 h-5 text-ink group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"/>
                </svg>
            </div>
            <span class="text-sm font-medium">Room</span>
        </a>

    </div>
</section>


{{-- ============================================================
     FEATURED LISTINGS — from DB, ordered by rating
============================================================ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex items-center justify-between mb-10">
        <div>
            <p class="text-xs uppercase tracking-widest text-silver mb-1">Handpicked for you</p>
            <h2 class="font-display text-3xl sm:text-4xl font-bold tracking-tight">Featured stays</h2>
        </div>
        <a href="{{ route('listings.index') }}" class="hidden sm:flex items-center gap-1 text-sm font-medium text-slate hover:text-ink transition-colors">
            See all <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6"/></svg>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
        @foreach ($featured as $listing)
        <a href="{{ route('listings.show', $listing->id) }}" class="lift group bg-white rounded-2xl overflow-hidden border border-fog flex flex-col">
            <div class="img-zoom relative" style="aspect-ratio:4/3;">
                @if ($listing->coverImage)
                    <img src="{{ $listing->coverImage->path }}" alt="{{ $listing->title }}" class="w-full h-full object-cover" loading="lazy" />
                @else
                    <div class="w-full h-full bg-fog flex items-center justify-center">
                        <svg class="w-10 h-10 text-silver" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909"/></svg>
                    </div>
                @endif
                <span class="absolute top-3 left-3 bg-ink/75 backdrop-blur-sm text-white text-[10px] uppercase tracking-widest font-semibold rounded-full px-2.5 py-1">{{ $listing->type }}</span>
            </div>
            <div class="flex flex-col flex-1 p-5 gap-3">
                <div class="flex items-start justify-between gap-2">
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-ink text-[0.95rem] leading-snug truncate">{{ $listing->title }}</h3>
                        <p class="text-xs text-silver mt-0.5">{{ $listing->city }}, {{ $listing->country }}</p>
                    </div>
                    @if ($listing->reviews_avg_rating)
                    <div class="flex items-center gap-1 shrink-0">
                        <svg class="w-3.5 h-3.5 text-ink" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <span class="text-xs font-semibold text-ink">{{ number_format($listing->reviews_avg_rating, 1) }}</span>
                        <span class="text-xs text-silver">({{ $listing->reviews->count() }})</span>
                    </div>
                    @endif
                </div>
                <p class="text-xs text-slate">{{ $listing->bedrooms }} bed{{ $listing->bedrooms > 1 ? 's' : '' }} &middot; Up to {{ $listing->max_guests }} guests</p>
                <div class="mt-auto flex items-center justify-between">
                    <p><span class="text-base font-bold">${{ number_format($listing->price_per_night / 100, 0) }}</span><span class="text-xs text-silver font-normal"> / night</span></p>
                    <span class="text-xs font-medium border border-fog rounded-full px-3 py-1 group-hover:bg-ink group-hover:text-white group-hover:border-ink transition-colors">View &rarr;</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <div class="sm:hidden mt-8 text-center">
        <a href="{{ route('listings.index') }}" class="inline-flex items-center gap-2 text-sm font-medium border border-fog rounded-full px-6 py-3 hover:border-ink transition-colors">
            See all listings &rarr;
        </a>
    </div>
</section>


{{-- ============================================================
     STATS STRIP
============================================================ --}}
<section class="bg-white border-y border-fog py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-8 text-center">
            <div>
                <p class="font-display text-4xl sm:text-5xl font-bold tracking-tight">1,200+</p>
                <p class="text-xs text-silver uppercase tracking-widest mt-1">Properties listed</p>
            </div>
            <div>
                <p class="font-display text-4xl sm:text-5xl font-bold tracking-tight">80+</p>
                <p class="text-xs text-silver uppercase tracking-widest mt-1">Cities covered</p>
            </div>
            <div>
                <p class="font-display text-4xl sm:text-5xl font-bold tracking-tight">4,500+</p>
                <p class="text-xs text-silver uppercase tracking-widest mt-1">Happy guests</p>
            </div>
            <div>
                <p class="font-display text-4xl sm:text-5xl font-bold tracking-tight">4.8 &#9733;</p>
                <p class="text-xs text-silver uppercase tracking-widest mt-1">Average rating</p>
            </div>
        </div>
    </div>
</section>


{{-- ============================================================
     HOW IT WORKS
============================================================ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="text-center mb-14">
        <p class="text-xs uppercase tracking-widest text-silver mb-2">Simple process</p>
        <h2 class="font-display text-3xl sm:text-4xl font-bold tracking-tight">How NestAway works</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-10">

        <div class="flex flex-col items-center text-center gap-5">
            <div class="relative">
                <div class="w-16 h-16 rounded-2xl bg-ink flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                    </svg>
                </div>
                <span class="font-display absolute -top-3 -right-3 text-4xl font-bold text-fog select-none leading-none">01</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-1">Search &amp; filter</h3>
                <p class="text-sm text-slate leading-relaxed">Browse hundreds of properties by location, type, price, and dates.</p>
            </div>
        </div>

        <div class="flex flex-col items-center text-center gap-5">
            <div class="relative">
                <div class="w-16 h-16 rounded-2xl bg-ink flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                    </svg>
                </div>
                <span class="font-display absolute -top-3 -right-3 text-4xl font-bold text-fog select-none leading-none">02</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-1">Book instantly</h3>
                <p class="text-sm text-slate leading-relaxed">Choose your dates and confirm your booking in just a few clicks.</p>
            </div>
        </div>

        <div class="flex flex-col items-center text-center gap-5">
            <div class="relative">
                <div class="w-16 h-16 rounded-2xl bg-ink flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"/>
                    </svg>
                </div>
                <span class="font-display absolute -top-3 -right-3 text-4xl font-bold text-fog select-none leading-none">03</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-1">Enjoy your stay</h3>
                <p class="text-sm text-slate leading-relaxed">Arrive, relax, and experience your destination like a local.</p>
            </div>
        </div>

    </div>
</section>


{{-- ============================================================
     RECENT LISTINGS — from DB, ordered by newest
============================================================ --}}
<section class="bg-white border-t border-fog py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10">
            <div>
                <p class="text-xs uppercase tracking-widest text-silver mb-1">Just added</p>
                <h2 class="font-display text-3xl sm:text-4xl font-bold tracking-tight">New arrivals</h2>
            </div>
            <a href="{{ route('listings.index', ['sort' => 'newest']) }}" class="hidden sm:flex items-center gap-1 text-sm font-medium text-slate hover:text-ink transition-colors">
                See all new <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ($recent as $listing)
            <a href="{{ route('listings.show', $listing->id) }}" class="lift group bg-cream rounded-2xl overflow-hidden border border-fog flex flex-col">
                <div class="img-zoom aspect-[4/3] bg-fog relative">
                    @if ($listing->coverImage)
                        <img src="{{ $listing->coverImage->path }}" alt="{{ $listing->title }}" class="w-full h-full object-cover" loading="lazy" />
                    @else
                        <div class="w-full h-full bg-fog flex items-center justify-center">
                            <svg class="w-8 h-8 text-silver" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909"/></svg>
                        </div>
                    @endif
                    <span class="absolute top-2 left-2 bg-ink text-white text-[9px] uppercase tracking-widest rounded-full px-2 py-0.5">New</span>
                </div>
                <div class="p-4 flex flex-col gap-1 flex-1">
                    <h3 class="text-sm font-semibold text-ink leading-snug line-clamp-2 group-hover:text-carbon transition-colors">{{ $listing->title }}</h3>
                    <p class="text-xs text-silver">{{ $listing->city }} &middot; {{ ucfirst($listing->type) }}</p>
                    <p class="mt-auto pt-3 text-sm font-bold text-ink">
                        ${{ number_format($listing->price_per_night / 100, 0) }}<span class="text-xs font-normal text-silver"> / night</span>
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>


{{-- ============================================================
     HOST CTA
============================================================ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-ink rounded-3xl px-8 sm:px-14 py-14 flex flex-col sm:flex-row items-center justify-between gap-8 relative overflow-hidden">
        <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full border border-white/10 pointer-events-none"></div>
        <div class="absolute -bottom-10 right-20 w-36 h-36 rounded-full border border-white/10 pointer-events-none"></div>
        <div class="relative text-white max-w-lg">
            <p class="text-xs uppercase tracking-widest text-silver mb-3">For property owners</p>
            <h2 class="font-display text-3xl sm:text-4xl font-bold leading-tight mb-4">Turn your space<br/>into income.</h2>
            <p class="text-silver text-sm leading-relaxed">List your property for free and start earning. We handle the platform so you focus on hosting.</p>
        </div>
        <div class="relative flex flex-col gap-3 shrink-0 w-full sm:w-auto">
            <a href="{{ url('/host') }}" class="bg-white text-ink font-semibold text-sm rounded-full px-8 py-3.5 hover:bg-fog transition-colors text-center">
                Become a Host &rarr;
            </a>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.style.opacity = '1';
                e.target.style.transform = 'translateY(0)';
                observer.unobserve(e.target);
            }
        });
    }, { threshold: 0.08 });

    document.querySelectorAll('.lift').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(14px)';
        card.style.transition = 'opacity 0.45s ease, transform 0.45s ease, box-shadow 0.28s ease';
        observer.observe(card);
    });
</script>
@endsection