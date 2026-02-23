@extends('layout')

@section('title', 'All Listings — NestAway')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Page header --}}
    <div class="mb-8">
        <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-ink">All listings</h1>
        {{-- DYNAMIC: $total = total count of listings matching current filters --}}
        <p class="text-sm text-silver mt-1">Showing 12 properties</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- ── SIDEBAR FILTERS ── --}}
        {{-- DYNAMIC: all filter inputs submit GET params to the same route --}}
        <aside class="w-full lg:w-64 shrink-0">
            <form action="{{ url('/listings') }}" method="GET" class="flex flex-col gap-6 bg-white border border-[#e4e2de] rounded-2xl p-6 sticky top-24">

                <h2 class="font-semibold text-sm text-ink uppercase tracking-widest">Filters</h2>

                {{-- Search --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs text-[#5c5c5c] uppercase tracking-widest font-medium">Location</label>
                    <input type="text" name="location" placeholder="City or address…"
                           value="{{ request('location') }}"
                           class="border border-[#e4e2de] rounded-xl px-3 py-2.5 text-sm text-ink placeholder-[#c0beba] bg-[#f6f4f0] focus:border-ink focus:outline-none transition-colors" />
                </div>

                {{-- Type --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs text-[#5c5c5c] uppercase tracking-widest font-medium">Type</label>
                    <div class="flex flex-col gap-2">
                        <label class="flex items-center gap-2 text-sm text-[#5c5c5c] cursor-pointer">
                            <input type="radio" name="type" value="" class="accent-ink"
                                {{ !request('type') ? 'checked' : '' }} /> Any
                        </label>
                        <label class="flex items-center gap-2 text-sm text-[#5c5c5c] cursor-pointer">
                            <input type="radio" name="type" value="apartment" class="accent-ink"
                                {{ request('type') == 'apartment' ? 'checked' : '' }} /> Apartment
                        </label>
                        <label class="flex items-center gap-2 text-sm text-[#5c5c5c] cursor-pointer">
                            <input type="radio" name="type" value="house" class="accent-ink"
                                {{ request('type') == 'house' ? 'checked' : '' }} /> House
                        </label>
                        <label class="flex items-center gap-2 text-sm text-[#5c5c5c] cursor-pointer">
                            <input type="radio" name="type" value="studio" class="accent-ink"
                                {{ request('type') == 'studio' ? 'checked' : '' }} /> Studio
                        </label>
                        <label class="flex items-center gap-2 text-sm text-[#5c5c5c] cursor-pointer">
                            <input type="radio" name="type" value="villa" class="accent-ink"
                                {{ request('type') == 'villa' ? 'checked' : '' }} /> Villa
                        </label>
                        <label class="flex items-center gap-2 text-sm text-[#5c5c5c] cursor-pointer">
                            <input type="radio" name="type" value="room" class="accent-ink"
                                {{ request('type') == 'room' ? 'checked' : '' }} /> Room
                        </label>
                    </div>
                </div>

                {{-- Price range --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs text-[#5c5c5c] uppercase tracking-widest font-medium">Price / night</label>
                    <div class="flex items-center gap-2">
                        <input type="number" name="price_min" placeholder="Min $"
                               value="{{ request('price_min') }}"
                               class="w-full border border-[#e4e2de] rounded-xl px-3 py-2.5 text-sm text-ink placeholder-[#c0beba] bg-[#f6f4f0] focus:border-ink focus:outline-none transition-colors" />
                        <span class="text-silver text-sm">—</span>
                        <input type="number" name="price_max" placeholder="Max $"
                               value="{{ request('price_max') }}"
                               class="w-full border border-[#e4e2de] rounded-xl px-3 py-2.5 text-sm text-ink placeholder-[#c0beba] bg-[#f6f4f0] focus:border-ink focus:outline-none transition-colors" />
                    </div>
                </div>

                {{-- Beds --}}
                <div class="flex flex-col gap-2">
                    <label class="text-xs text-[#5c5c5c] uppercase tracking-widest font-medium">Min. beds</label>
                    <select name="beds"
                            class="border border-[#e4e2de] rounded-xl px-3 py-2.5 text-sm text-ink bg-[#f6f4f0] focus:border-ink focus:outline-none transition-colors">
                        <option value="">Any</option>
                        <option value="1" {{ request('beds') == '1' ? 'selected' : '' }}>1+</option>
                        <option value="2" {{ request('beds') == '2' ? 'selected' : '' }}>2+</option>
                        <option value="3" {{ request('beds') == '3' ? 'selected' : '' }}>3+</option>
                        <option value="4" {{ request('beds') == '4' ? 'selected' : '' }}>4+</option>
                    </select>
                </div>

                <div class="flex flex-col gap-2 pt-1 border-t border-[#e4e2de]">
                    <button type="submit"
                            class="w-full bg-ink text-white text-sm font-medium rounded-xl py-2.5 hover:bg-[#2a2a2a] transition-colors">
                        Apply filters
                    </button>
                    <a href="{{ url('/listings') }}"
                       class="w-full text-center text-sm text-silver hover:text-ink transition-colors py-1">
                        Clear all
                    </a>
                </div>

            </form>
        </aside>

        {{-- ── LISTINGS GRID ── --}}
        <div class="flex-1">

            {{-- Sort bar --}}
            <div class="flex items-center justify-between mb-6">
                {{-- DYNAMIC: mobile filter toggle (optional enhancement) --}}
                <p class="text-sm text-silver">12 results</p>
                <select name="sort" onchange="this.form && this.form.submit()"
                        class="border border-[#e4e2de] rounded-xl px-3 py-2 text-sm text-ink bg-white focus:border-ink focus:outline-none transition-colors">
                    <option value="newest">Newest first</option>
                    <option value="price_asc">Price: low to high</option>
                    <option value="price_desc">Price: high to low</option>
                    <option value="rating">Top rated</option>
                </select>
            </div>

            {{-- DYNAMIC: replace static cards with @foreach ($listings as $listing)
                 Pass from controller: return view('listings.index', ['listings' => Listing::paginate(12)]);
                 All hrefs below point to /listings/1 for now --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">

                {{-- Card 1 --}}
                <a href="{{ url('/listings/1') }}" cl       ass="lift group bg-white rounded-2xl overflow-hidden border border-[#e4e2de] flex flex-col">
                    <div class="img-zoom relative" style="aspect-ratio:4/3">
                        <img src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=600&q=80" class="w-full h-full object-cover" loading="lazy" />
                        <span class="absolute top-3 left-3 bg-ink/75 backdrop-blur-sm text-white text-[10px] uppercase tracking-widest font-semibold rounded-full px-2.5 py-1">Apartment</span>
                    </div>
                    <div class="p-4 flex flex-col gap-2 flex-1">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <h3 class="font-semibold text-sm text-ink truncate">Modern Loft in Bairro Alto</h3>
                                <p class="text-xs text-silver mt-0.5">Lisbon</p>
                            </div>
                            <div class="flex items-center gap-1 shrink-0 text-xs">
                                <svg class="w-3.5 h-3.5 text-ink" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-semibold text-ink">4.9</span>
                                <span class="text-silver">(38)</span>
                            </div>
                        </div>
                        <p class="text-xs text-[#5c5c5c]">1 bed &middot; Entire place</p>
                        <p class="mt-auto text-sm font-bold text-ink">$85 <span class="text-xs font-normal text-silver">/ night</span></p>
                    </div>
                </a>

                {{-- Card 2 --}}
                <a href="{{ url('/listings/1') }}" class="lift group bg-white rounded-2xl overflow-hidden border border-[#e4e2de] flex flex-col">
                    <div class="img-zoom relative" style="aspect-ratio:4/3">
                        <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=600&q=80" class="w-full h-full object-cover" loading="lazy" />
                        <span class="absolute top-3 left-3 bg-ink/75 backdrop-blur-sm text-white text-[10px] uppercase tracking-widest font-semibold rounded-full px-2.5 py-1">Villa</span>
                    </div>
                    <div class="p-4 flex flex-col gap-2 flex-1">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <h3 class="font-semibold text-sm text-ink truncate">Beachfront Villa with Pool</h3>
                                <p class="text-xs text-silver mt-0.5">Lagos</p>
                            </div>
                            <div class="flex items-center gap-1 shrink-0 text-xs">
                                <svg class="w-3.5 h-3.5 text-ink" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-semibold text-ink">5.0</span>
                                <span class="text-silver">(21)</span>
                            </div>
                        </div>
                        <p class="text-xs text-[#5c5c5c]">4 beds &middot; Entire place</p>
                        <p class="mt-auto text-sm font-bold text-ink">$230 <span class="text-xs font-normal text-silver">/ night</span></p>
                    </div>
                </a>

                {{-- Card 3 --}}
                <a href="{{ url('/listings/1') }}" class="lift group bg-white rounded-2xl overflow-hidden border border-[#e4e2de] flex flex-col">
                    <div class="img-zoom relative" style="aspect-ratio:4/3">
                        <img src="https://images.unsplash.com/photo-1493809842364-78817add7ffb?w=600&q=80" class="w-full h-full object-cover" loading="lazy" />
                        <span class="absolute top-3 left-3 bg-ink/75 backdrop-blur-sm text-white text-[10px] uppercase tracking-widest font-semibold rounded-full px-2.5 py-1">Studio</span>
                    </div>
                    <div class="p-4 flex flex-col gap-2 flex-1">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <h3 class="font-semibold text-sm text-ink truncate">Cosy Studio near the River</h3>
                                <p class="text-xs text-silver mt-0.5">Porto</p>
                            </div>
                            <div class="flex items-center gap-1 shrink-0 text-xs">
                                <svg class="w-3.5 h-3.5 text-ink" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-semibold text-ink">4.7</span>
                                <span class="text-silver">(64)</span>
                            </div>
                        </div>
                        <p class="text-xs text-[#5c5c5c]">1 bed &middot; Entire place</p>
                        <p class="mt-auto text-sm font-bold text-ink">$55 <span class="text-xs font-normal text-silver">/ night</span></p>
                    </div>
                </a>

                {{-- Card 4 --}}
                <a href="{{ url('/listings/1') }}" class="lift group bg-white rounded-2xl overflow-hidden border border-[#e4e2de] flex flex-col">
                    <div class="img-zoom relative" style="aspect-ratio:4/3">
                        <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=600&q=80" class="w-full h-full object-cover" loading="lazy" />
                        <span class="absolute top-3 left-3 bg-ink/75 backdrop-blur-sm text-white text-[10px] uppercase tracking-widest font-semibold rounded-full px-2.5 py-1">House</span>
                    </div>
                    <div class="p-4 flex flex-col gap-2 flex-1">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <h3 class="font-semibold text-sm text-ink truncate">Historic Townhouse, Old Town</h3>
                                <p class="text-xs text-silver mt-0.5">Sintra</p>
                            </div>
                            <div class="flex items-center gap-1 shrink-0 text-xs">
                                <svg class="w-3.5 h-3.5 text-ink" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-semibold text-ink">4.8</span>
                                <span class="text-silver">(17)</span>
                            </div>
                        </div>
                        <p class="text-xs text-[#5c5c5c]">3 beds &middot; Entire place</p>
                        <p class="mt-auto text-sm font-bold text-ink">$140 <span class="text-xs font-normal text-silver">/ night</span></p>
                    </div>
                </a>

                {{-- Card 5 --}}
                <a href="{{ url('/listings/1') }}" class="lift group bg-white rounded-2xl overflow-hidden border border-[#e4e2de] flex flex-col">
                    <div class="img-zoom relative" style="aspect-ratio:4/3">
                        <img src="https://images.unsplash.com/photo-1505691723518-36a5ac3be353?w=600&q=80" class="w-full h-full object-cover" loading="lazy" />
                        <span class="absolute top-3 left-3 bg-ink/75 backdrop-blur-sm text-white text-[10px] uppercase tracking-widest font-semibold rounded-full px-2.5 py-1">Apartment</span>
                    </div>
                    <div class="p-4 flex flex-col gap-2 flex-1">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <h3 class="font-semibold text-sm text-ink truncate">Bright Apartment, Sea View</h3>
                                <p class="text-xs text-silver mt-0.5">Cascais</p>
                            </div>
                            <div class="flex items-center gap-1 shrink-0 text-xs">
                                <svg class="w-3.5 h-3.5 text-ink" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-semibold text-ink">4.9</span>
                                <span class="text-silver">(44)</span>
                            </div>
                        </div>
                        <p class="text-xs text-[#5c5c5c]">2 beds &middot; Entire place</p>
                        <p class="mt-auto text-sm font-bold text-ink">$110 <span class="text-xs font-normal text-silver">/ night</span></p>
                    </div>
                </a>

                {{-- Card 6 --}}
                <a href="{{ url('/listings/1') }}" class="lift group bg-white rounded-2xl overflow-hidden border border-[#e4e2de] flex flex-col">
                    <div class="img-zoom relative" style="aspect-ratio:4/3">
                        <img src="https://images.unsplash.com/photo-1449844908441-8829872d2607?w=600&q=80" class="w-full h-full object-cover" loading="lazy" />
                        <span class="absolute top-3 left-3 bg-ink/75 backdrop-blur-sm text-white text-[10px] uppercase tracking-widest font-semibold rounded-full px-2.5 py-1">House</span>
                    </div>
                    <div class="p-4 flex flex-col gap-2 flex-1">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <h3 class="font-semibold text-sm text-ink truncate">Rustic Farmhouse Retreat</h3>
                                <p class="text-xs text-silver mt-0.5">Alentejo</p>
                            </div>
                            <div class="flex items-center gap-1 shrink-0 text-xs">
                                <svg class="w-3.5 h-3.5 text-ink" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-semibold text-ink">4.6</span>
                                <span class="text-silver">(9)</span>
                            </div>
                        </div>
                        <p class="text-xs text-[#5c5c5c]">5 beds &middot; Entire place</p>
                        <p class="mt-auto text-sm font-bold text-ink">$175 <span class="text-xs font-normal text-silver">/ night</span></p>
                    </div>
                </a>

                {{-- Card 7 --}}
                <a href="{{ url('/listings/1') }}" class="lift group bg-white rounded-2xl overflow-hidden border border-[#e4e2de] flex flex-col">
                    <div class="img-zoom relative" style="aspect-ratio:4/3">
                        <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=600&q=80" class="w-full h-full object-cover" loading="lazy" />
                        <span class="absolute top-3 left-3 bg-ink/75 backdrop-blur-sm text-white text-[10px] uppercase tracking-widest font-semibold rounded-full px-2.5 py-1">Apartment</span>
                    </div>
                    <div class="p-4 flex flex-col gap-2 flex-1">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <h3 class="font-semibold text-sm text-ink truncate">Penthouse with Rooftop Terrace</h3>
                                <p class="text-xs text-silver mt-0.5">Lisbon</p>
                            </div>
                            <div class="flex items-center gap-1 shrink-0 text-xs">
                                <svg class="w-3.5 h-3.5 text-ink" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-semibold text-ink">4.9</span>
                                <span class="text-silver">(12)</span>
                            </div>
                        </div>
                        <p class="text-xs text-[#5c5c5c]">2 beds &middot; Entire place</p>
                        <p class="mt-auto text-sm font-bold text-ink">$195 <span class="text-xs font-normal text-silver">/ night</span></p>
                    </div>
                </a>

                {{-- Card 8 --}}
                <a href="{{ url('/listings/1') }}" class="lift group bg-white rounded-2xl overflow-hidden border border-[#e4e2de] flex flex-col">
                    <div class="img-zoom relative" style="aspect-ratio:4/3">
                        <img src="https://images.unsplash.com/photo-1518780664697-55e3ad937233?w=600&q=80" class="w-full h-full object-cover" loading="lazy" />
                        <span class="absolute top-3 left-3 bg-ink/75 backdrop-blur-sm text-white text-[10px] uppercase tracking-widest font-semibold rounded-full px-2.5 py-1">House</span>
                    </div>
                    <div class="p-4 flex flex-col gap-2 flex-1">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <h3 class="font-semibold text-sm text-ink truncate">Garden Cottage near Forest</h3>
                                <p class="text-xs text-silver mt-0.5">Sintra</p>
                            </div>
                            <div class="flex items-center gap-1 shrink-0 text-xs">
                                <svg class="w-3.5 h-3.5 text-ink" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-semibold text-ink">4.7</span>
                                <span class="text-silver">(29)</span>
                            </div>
                        </div>
                        <p class="text-xs text-[#5c5c5c]">2 beds &middot; Entire place</p>
                        <p class="mt-auto text-sm font-bold text-ink">$90 <span class="text-xs font-normal text-silver">/ night</span></p>
                    </div>
                </a>

                {{-- Card 9 --}}
                <a href="{{ url('/listings/1') }}" class="lift group bg-white rounded-2xl overflow-hidden border border-[#e4e2de] flex flex-col">
                    <div class="img-zoom relative" style="aspect-ratio:4/3">
                        <img src="https://images.unsplash.com/photo-1484101403633-562f891dc89a?w=600&q=80" class="w-full h-full object-cover" loading="lazy" />
                        <span class="absolute top-3 left-3 bg-ink/75 backdrop-blur-sm text-white text-[10px] uppercase tracking-widest font-semibold rounded-full px-2.5 py-1">Apartment</span>
                    </div>
                    <div class="p-4 flex flex-col gap-2 flex-1">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <h3 class="font-semibold text-sm text-ink truncate">Art Deco Flat, City Centre</h3>
                                <p class="text-xs text-silver mt-0.5">Porto</p>
                            </div>
                            <div class="flex items-center gap-1 shrink-0 text-xs">
                                <svg class="w-3.5 h-3.5 text-ink" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-semibold text-ink">4.8</span>
                                <span class="text-silver">(33)</span>
                            </div>
                        </div>
                        <p class="text-xs text-[#5c5c5c]">1 bed &middot; Entire place</p>
                        <p class="mt-auto text-sm font-bold text-ink">$75 <span class="text-xs font-normal text-silver">/ night</span></p>
                    </div>
                </a>

                {{-- Card 10 --}}
                <a href="{{ url('/listings/1') }}" class="lift group bg-white rounded-2xl overflow-hidden border border-[#e4e2de] flex flex-col">
                    <div class="img-zoom relative" style="aspect-ratio:4/3">
                        <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=600&q=80" class="w-full h-full object-cover" loading="lazy" />
                        <span class="absolute top-3 left-3 bg-ink/75 backdrop-blur-sm text-white text-[10px] uppercase tracking-widest font-semibold rounded-full px-2.5 py-1">Studio</span>
                    </div>
                    <div class="p-4 flex flex-col gap-2 flex-1">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <h3 class="font-semibold text-sm text-ink truncate">Cliffside Studio, Sea Views</h3>
                                <p class="text-xs text-silver mt-0.5">Sesimbra</p>
                            </div>
                            <div class="flex items-center gap-1 shrink-0 text-xs">
                                <svg class="w-3.5 h-3.5 text-ink" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-semibold text-ink">4.9</span>
                                <span class="text-silver">(18)</span>
                            </div>
                        </div>
                        <p class="text-xs text-[#5c5c5c]">1 bed &middot; Entire place</p>
                        <p class="mt-auto text-sm font-bold text-ink">$68 <span class="text-xs font-normal text-silver">/ night</span></p>
                    </div>
                </a>

                {{-- Card 11 --}}
                <a href="{{ url('/listings/1') }}" class="lift group bg-white rounded-2xl overflow-hidden border border-[#e4e2de] flex flex-col">
                    <div class="img-zoom relative" style="aspect-ratio:4/3">
                        <img src="https://images.unsplash.com/photo-1416331108676-a22ccb276e35?w=600&q=80" class="w-full h-full object-cover" loading="lazy" />
                        <span class="absolute top-3 left-3 bg-ink/75 backdrop-blur-sm text-white text-[10px] uppercase tracking-widest font-semibold rounded-full px-2.5 py-1">Villa</span>
                    </div>
                    <div class="p-4 flex flex-col gap-2 flex-1">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <h3 class="font-semibold text-sm text-ink truncate">Hilltop Villa, Private Garden</h3>
                                <p class="text-xs text-silver mt-0.5">Óbidos</p>
                            </div>
                            <div class="flex items-center gap-1 shrink-0 text-xs">
                                <svg class="w-3.5 h-3.5 text-ink" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-semibold text-ink">4.8</span>
                                <span class="text-silver">(7)</span>
                            </div>
                        </div>
                        <p class="text-xs text-[#5c5c5c]">3 beds &middot; Entire place</p>
                        <p class="mt-auto text-sm font-bold text-ink">$210 <span class="text-xs font-normal text-silver">/ night</span></p>
                    </div>
                </a>

                {{-- Card 12 --}}
                <a href="{{ url('/listings/1') }}" class="lift group bg-white rounded-2xl overflow-hidden border border-[#e4e2de] flex flex-col">
                    <div class="img-zoom relative" style="aspect-ratio:4/3">
                        <img src="https://images.unsplash.com/photo-1462275646964-a0e3386b89fa?w=600&q=80" class="w-full h-full object-cover" loading="lazy" />
                        <span class="absolute top-3 left-3 bg-ink/75 backdrop-blur-sm text-white text-[10px] uppercase tracking-widest font-semibold rounded-full px-2.5 py-1">Room</span>
                    </div>
                    <div class="p-4 flex flex-col gap-2 flex-1">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <h3 class="font-semibold text-sm text-ink truncate">Sunny Room in Shared House</h3>
                                <p class="text-xs text-silver mt-0.5">Lisbon</p>
                            </div>
                            <div class="flex items-center gap-1 shrink-0 text-xs">
                                <svg class="w-3.5 h-3.5 text-ink" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-semibold text-ink">4.5</span>
                                <span class="text-silver">(52)</span>
                            </div>
                        </div>
                        <p class="text-xs text-[#5c5c5c]">1 bed &middot; Private room</p>
                        <p class="mt-auto text-sm font-bold text-ink">$35 <span class="text-xs font-normal text-silver">/ night</span></p>
                    </div>
                </a>

            </div>

            {{-- DYNAMIC: replace with {{ $listings->links() }} when using paginate() --}}
            <div class="flex items-center justify-center gap-2 mt-12">
                <button class="w-9 h-9 rounded-full border border-[#e4e2de] flex items-center justify-center text-silver hover:border-ink hover:text-ink transition-colors" disabled>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/></svg>
                </button>
                <button class="w-9 h-9 rounded-full bg-ink text-white text-sm font-medium">1</button>
                <button class="w-9 h-9 rounded-full border border-[#e4e2de] text-sm text-[#5c5c5c] hover:border-ink hover:text-ink transition-colors">2</button>
                <button class="w-9 h-9 rounded-full border border-[#e4e2de] text-sm text-[#5c5c5c] hover:border-ink hover:text-ink transition-colors">3</button>
                <button class="w-9 h-9 rounded-full border border-[#e4e2de] flex items-center justify-center text-[#5c5c5c] hover:border-ink hover:text-ink transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6"/></svg>
                </button>
            </div>

        </div>
    </div>
</div>

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