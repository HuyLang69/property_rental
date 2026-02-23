@extends('layout')

@section('title', 'Modern Loft in Bairro Alto — NestAway')

@section('content')

{{-- DYNAMIC: all values below come from $listing passed by your controller
     e.g. return view('listings.show', ['listing' => Listing::findOrFail($id)]); --}}

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-silver mb-6">
        <a href="{{ url('/') }}" class="hover:text-ink transition-colors">Home</a>
        <span>/</span>
        <a href="{{ url('/listings') }}" class="hover:text-ink transition-colors">Listings</a>
        <span>/</span>
        {{-- DYNAMIC: $listing->title --}}
        <span class="text-ink">Modern Loft in Bairro Alto</span>
    </nav>

    {{-- Title row --}}
    <div class="flex items-start justify-between gap-4 mb-6">
        <div>
            {{-- DYNAMIC: $listing->title --}}
            <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-ink">Modern Loft in Bairro Alto</h1>
            <div class="flex items-center flex-wrap gap-3 mt-2 text-sm text-[#5c5c5c]">
                <div class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-ink" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    {{-- DYNAMIC: $listing->average_rating · $listing->reviews_count --}}
                    <span class="font-semibold text-ink">4.9</span>
                    <span class="text-silver">(38 reviews)</span>
                </div>
                <span class="text-[#e4e2de]">·</span>
                {{-- DYNAMIC: $listing->city, $listing->country --}}
                <span>Lisbon, Portugal</span>
            </div>
        </div>
        <button class="flex items-center gap-2 border border-[#e4e2de] rounded-full px-4 py-2 text-sm text-[#5c5c5c] hover:border-ink hover:text-ink transition-colors shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            Save
        </button>
    </div>

    {{-- Photo grid --}}
    {{-- DYNAMIC: $listing->images — replace src with $image->url --}}
    <div class="grid grid-cols-4 grid-rows-2 gap-2 rounded-2xl overflow-hidden h-[420px] mb-10">
        <div class="col-span-2 row-span-2">
            <img src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=900&q=80" class="w-full h-full object-cover" />
        </div>
        <div>
            <img src="https://images.unsplash.com/photo-1484101403633-562f891dc89a?w=500&q=80" class="w-full h-full object-cover" />
        </div>
        <div>
            <img src="https://images.unsplash.com/photo-1493809842364-78817add7ffb?w=500&q=80" class="w-full h-full object-cover" />
        </div>
        <div>
            <img src="https://images.unsplash.com/photo-1505691723518-36a5ac3be353?w=500&q=80" class="w-full h-full object-cover" />
        </div>
        <div class="relative">
            <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=500&q=80" class="w-full h-full object-cover" />
            <button class="absolute bottom-3 right-3 bg-white text-ink text-xs font-medium rounded-full px-3 py-1.5 border border-[#e4e2de] hover:border-ink transition-colors">
                Show all photos
            </button>
        </div>
    </div>

    {{-- Main content + booking widget --}}
    <div class="flex flex-col lg:flex-row gap-12">

        {{-- ── LEFT: property details ── --}}
        <div class="flex-1 min-w-0">

            {{-- Quick facts --}}
            <div class="flex items-center flex-wrap gap-4 pb-8 border-b border-[#e4e2de]">
                {{-- DYNAMIC: $listing->type, beds, bathrooms, max_guests --}}
                <div class="flex flex-col">
                    <span class="text-xs uppercase tracking-widest text-silver">Type</span>
                    <span class="text-sm font-medium text-ink mt-0.5">Entire apartment</span>
                </div>
                <div class="w-px h-8 bg-[#e4e2de]"></div>
                <div class="flex flex-col">
                    <span class="text-xs uppercase tracking-widest text-silver">Beds</span>
                    <span class="text-sm font-medium text-ink mt-0.5">1 bedroom</span>
                </div>
                <div class="w-px h-8 bg-[#e4e2de]"></div>
                <div class="flex flex-col">
                    <span class="text-xs uppercase tracking-widest text-silver">Bathrooms</span>
                    <span class="text-sm font-medium text-ink mt-0.5">1 bathroom</span>
                </div>
                <div class="w-px h-8 bg-[#e4e2de]"></div>
                <div class="flex flex-col">
                    <span class="text-xs uppercase tracking-widest text-silver">Guests</span>
                    <span class="text-sm font-medium text-ink mt-0.5">Up to 2</span>
                </div>
            </div>

            {{-- Host --}}
            <div class="flex items-center gap-4 py-8 border-b border-[#e4e2de]">
                {{-- DYNAMIC: $listing->host->name, $listing->host->avatar_url, $listing->host->created_at --}}
                <div class="w-12 h-12 rounded-full bg-[#e4e2de] flex items-center justify-center shrink-0 overflow-hidden">
                    <svg class="w-6 h-6 text-silver" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-ink">Hosted by Maria Santos</p>
                    <p class="text-xs text-silver mt-0.5">Host since January 2022</p>
                </div>
            </div>

            {{-- Description --}}
            <div class="py-8 border-b border-[#e4e2de]">
                <h2 class="font-display text-xl font-bold text-ink mb-3">About this place</h2>
                {{-- DYNAMIC: $listing->description --}}
                <p class="text-sm text-[#5c5c5c] leading-relaxed">
                    A beautifully designed loft in the heart of Bairro Alto, Lisbon's most vibrant neighbourhood. High ceilings, exposed brick walls, and large windows fill the space with natural light throughout the day. Just steps away from the best restaurants, bars, and miradouros the city has to offer.
                </p>
                <p class="text-sm text-[#5c5c5c] leading-relaxed mt-3">
                    The space is perfect for couples or solo travellers looking to experience Lisbon like a local. The kitchen is fully equipped, and fast Wi-Fi is available throughout.
                </p>
            </div>

            {{-- Amenities --}}
            <div class="py-8 border-b border-[#e4e2de]">
                <h2 class="font-display text-xl font-bold text-ink mb-5">Amenities</h2>
                {{-- DYNAMIC: @foreach ($listing->amenities as $amenity) --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="flex items-center gap-3 text-sm text-[#5c5c5c]">
                        <svg class="w-5 h-5 text-ink shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 011.06 0z"/></svg>
                        Wi-Fi
                    </div>
                    <div class="flex items-center gap-3 text-sm text-[#5c5c5c]">
                        <svg class="w-5 h-5 text-ink shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 012.092 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75"/></svg>
                        Kitchen
                    </div>
                    <div class="flex items-center gap-3 text-sm text-[#5c5c5c]">
                        <svg class="w-5 h-5 text-ink shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                        Air conditioning
                    </div>
                    <div class="flex items-center gap-3 text-sm text-[#5c5c5c]">
                        <svg class="w-5 h-5 text-ink shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 20.25h12m-7.5-3v3m3-3v3m-10.125-3h17.25c.621 0 1.125-.504 1.125-1.125V4.875c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125z"/></svg>
                        Smart TV
                    </div>
                    <div class="flex items-center gap-3 text-sm text-[#5c5c5c]">
                        <svg class="w-5 h-5 text-ink shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Self check-in
                    </div>
                    <div class="flex items-center gap-3 text-sm text-[#5c5c5c]">
                        <svg class="w-5 h-5 text-ink shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/></svg>
                        Washer
                    </div>
                </div>
            </div>

            {{-- Reviews --}}
            <div class="py-8">
                <div class="flex items-center gap-3 mb-6">
                    <svg class="w-5 h-5 text-ink" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    {{-- DYNAMIC: $listing->average_rating · $listing->reviews_count --}}
                    <h2 class="font-display text-xl font-bold text-ink">4.9 &middot; 38 reviews</h2>
                </div>

                {{-- DYNAMIC: @foreach ($listing->reviews->take(4) as $review) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-[#e4e2de] flex items-center justify-center text-xs font-semibold text-ink shrink-0">JR</div>
                            <div>
                                <p class="text-sm font-semibold text-ink">João R.</p>
                                <p class="text-xs text-silver">October 2024</p>
                            </div>
                        </div>
                        <p class="text-sm text-[#5c5c5c] leading-relaxed">Fantastic location, clean and stylish. Maria was an excellent host and very responsive. Would definitely come back!</p>
                    </div>

                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-[#e4e2de] flex items-center justify-center text-xs font-semibold text-ink shrink-0">SM</div>
                            <div>
                                <p class="text-sm font-semibold text-ink">Sophie M.</p>
                                <p class="text-xs text-silver">September 2024</p>
                            </div>
                        </div>
                        <p class="text-sm text-[#5c5c5c] leading-relaxed">Loved the neighbourhood! The loft is exactly as shown in the photos, very comfortable and quiet at night despite being so central.</p>
                    </div>

                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-[#e4e2de] flex items-center justify-center text-xs font-semibold text-ink shrink-0">TK</div>
                            <div>
                                <p class="text-sm font-semibold text-ink">Tom K.</p>
                                <p class="text-xs text-silver">August 2024</p>
                            </div>
                        </div>
                        <p class="text-sm text-[#5c5c5c] leading-relaxed">Great value for Lisbon. The kitchen was well-stocked and Wi-Fi was fast. Perfect for working remotely.</p>
                    </div>

                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-[#e4e2de] flex items-center justify-center text-xs font-semibold text-ink shrink-0">AL</div>
                            <div>
                                <p class="text-sm font-semibold text-ink">Ana L.</p>
                                <p class="text-xs text-silver">July 2024</p>
                            </div>
                        </div>
                        <p class="text-sm text-[#5c5c5c] leading-relaxed">The space has a great vibe — cosy but open. We loved sitting by the window with coffee in the mornings. Highly recommend.</p>
                    </div>

                </div>

                <button class="mt-6 border border-[#e4e2de] rounded-full px-5 py-2.5 text-sm font-medium text-ink hover:border-ink transition-colors">
                    Show all 38 reviews
                </button>
            </div>

        </div>

        {{-- ── RIGHT: booking widget ── --}}
        <div class="w-full lg:w-80 xl:w-96 shrink-0">
            <div class="sticky top-24 bg-white border border-[#e4e2de] rounded-2xl p-6 shadow-sm">

                {{-- Price --}}
                <div class="flex items-baseline gap-1 mb-6">
                    {{-- DYNAMIC: $listing->price_per_night --}}
                    <span class="font-display text-3xl font-bold text-ink">$85</span>
                    <span class="text-sm text-silver">/ night</span>
                </div>

                {{-- DYNAMIC: form posts to your bookings.store route --}}
                <form action="{{ url('/bookings') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    {{-- DYNAMIC: hidden field for listing id --}}
                    <input type="hidden" name="listing_id" value="1" />

                    {{-- Dates --}}
                    <div class="border border-[#e4e2de] rounded-xl overflow-hidden">
                        <div class="grid grid-cols-2 divide-x divide-[#e4e2de]">
                            <div class="px-3 py-2.5">
                                <p class="text-[10px] uppercase tracking-widest text-silver font-medium">Check-in</p>
                                <input type="date" name="check_in" class="w-full text-sm text-ink bg-transparent focus:outline-none mt-0.5 cursor-pointer" />
                            </div>
                            <div class="px-3 py-2.5">
                                <p class="text-[10px] uppercase tracking-widest text-silver font-medium">Check-out</p>
                                <input type="date" name="check_out" class="w-full text-sm text-ink bg-transparent focus:outline-none mt-0.5 cursor-pointer" />
                            </div>
                        </div>
                        <div class="border-t border-[#e4e2de] px-3 py-2.5">
                            <p class="text-[10px] uppercase tracking-widest text-silver font-medium">Guests</p>
                            <select name="guests" class="w-full text-sm text-ink bg-transparent focus:outline-none mt-0.5 cursor-pointer">
                                <option value="1">1 guest</option>
                                <option value="2">2 guests</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-ink text-white font-medium text-sm rounded-xl py-3.5 hover:bg-[#2a2a2a] transition-colors">
                        Reserve
                    </button>
                </form>

                <p class="text-center text-xs text-silver mt-3">You won't be charged yet</p>

                {{-- Price breakdown (static for now) --}}
                {{-- DYNAMIC: calculate based on selected dates --}}
                <div class="mt-5 flex flex-col gap-2.5 pt-5 border-t border-[#e4e2de] text-sm">
                    <div class="flex justify-between text-[#5c5c5c]">
                        <span>$85 &times; 5 nights</span>
                        <span>$425</span>
                    </div>
                    <div class="flex justify-between text-[#5c5c5c]">
                        <span>Cleaning fee</span>
                        <span>$30</span>
                    </div>
                    <div class="flex justify-between text-[#5c5c5c]">
                        <span>Service fee</span>
                        <span>$45</span>
                    </div>
                    <div class="flex justify-between font-semibold text-ink pt-2.5 border-t border-[#e4e2de]">
                        <span>Total</span>
                        <span>$500</span>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection