@extends('layout')

@section('title', $listing->title . ' — NestAway')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-silver mb-6">
        <a href="{{ route('home') }}" class="hover:text-ink transition-colors">Home</a>
        <span>/</span>
        <a href="{{ route('listings.index') }}" class="hover:text-ink transition-colors">Listings</a>
        <span>/</span>
        <span class="text-ink truncate max-w-xs">{{ $listing->title }}</span>
    </nav>

    {{-- Title row --}}
    <div class="mb-6">
        <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-ink">{{ $listing->title }}</h1>
        <div class="flex items-center flex-wrap gap-3 mt-2 text-sm text-slate">
            @if ($listing->reviews_avg_rating)
            <div class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-ink" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <span class="font-semibold text-ink">{{ number_format($listing->reviews_avg_rating, 1) }}</span>
                <span class="text-silver">({{ $listing->reviews_count }} {{ Str::plural('review', $listing->reviews_count) }})</span>
                <span class="text-fog">·</span>
            </div>
            @endif
            <span>{{ $listing->city }}, {{ $listing->country }}</span>
        </div>
    </div>

    {{-- Photo grid --}}
    @php $images = $listing->images; @endphp
    <div class="rounded-2xl overflow-hidden mb-10 bg-fog"
         style="display:grid; grid-template-columns:2fr 1fr 1fr; grid-template-rows:1fr 1fr; gap:4px; height:420px;">

        <div style="grid-row: span 2; overflow:hidden;">
            @if ($images->count() > 0)
                <img src="{{ $images[0]->url }}" alt="{{ $listing->title }}" class="w-full h-full object-cover" />
            @else
                <div class="w-full h-full bg-fog flex items-center justify-center">
                    <svg class="w-12 h-12 text-silver" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909"/></svg>
                </div>
            @endif
        </div>

        @foreach ([1, 2, 3, 4] as $i)
        <div style="overflow:hidden;">
            @if ($images->count() > $i)
                <img src="{{ $images[$i]->url }}" alt="{{ $listing->title }}" class="w-full h-full object-cover" loading="lazy" />
            @else
                <div class="w-full h-full bg-fog"></div>
            @endif
        </div>
        @endforeach

    </div>

    {{-- Main content + booking widget --}}
    <div class="flex flex-col lg:flex-row gap-12">

        {{-- ── LEFT ── --}}
        <div class="flex-1 min-w-0">

            {{-- Quick facts --}}
            <div class="flex items-center flex-wrap gap-6 pb-8 border-b border-fog">
                <div class="flex flex-col">
                    <span class="text-xs uppercase tracking-widest text-silver">Type</span>
                    <span class="text-sm font-medium text-ink mt-0.5">{{ ucfirst($listing->type) }}</span>
                </div>
                <div class="w-px h-8 bg-fog"></div>
                <div class="flex flex-col">
                    <span class="text-xs uppercase tracking-widest text-silver">Bedrooms</span>
                    <span class="text-sm font-medium text-ink mt-0.5">{{ $listing->bedrooms }}</span>
                </div>
                <div class="w-px h-8 bg-fog"></div>
                <div class="flex flex-col">
                    <span class="text-xs uppercase tracking-widest text-silver">Bathrooms</span>
                    <span class="text-sm font-medium text-ink mt-0.5">{{ $listing->bathrooms }}</span>
                </div>
                <div class="w-px h-8 bg-fog"></div>
                <div class="flex flex-col">
                    <span class="text-xs uppercase tracking-widest text-silver">Max guests</span>
                    <span class="text-sm font-medium text-ink mt-0.5">{{ $listing->max_guests }}</span>
                </div>
            </div>

            {{-- Host --}}
            <div class="flex items-center gap-4 py-8 border-b border-fog">
                <div class="w-12 h-12 rounded-full bg-fog flex items-center justify-center shrink-0 overflow-hidden">
                    @if ($listing->host->avatar)
                        <img src="{{ $listing->host->avatar }}" class="w-full h-full object-cover" />
                    @else
                        <svg class="w-6 h-6 text-silver" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/>
                        </svg>
                    @endif
                </div>
                <div>
                    <p class="text-sm font-semibold text-ink">Hosted by {{ $listing->host->full_name }}</p>
                    <p class="text-xs text-silver mt-0.5">Host since {{ $listing->host->created_at->format('F Y') }}</p>
                </div>
            </div>

            {{-- Description --}}
            <div class="py-8 border-b border-fog">
                <h2 class="font-display text-xl font-bold text-ink mb-3">About this place</h2>
                <p class="text-sm text-slate leading-relaxed">{{ $listing->description }}</p>
            </div>

            {{-- Reviews --}}
            @if ($listing->reviews->count() > 0)
            <div class="py-8">
                <div class="flex items-center gap-3 mb-6">
                    <svg class="w-5 h-5 text-ink" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <h2 class="font-display text-xl font-bold text-ink">
                        {{ number_format($listing->reviews_avg_rating, 1) }} &middot; {{ $listing->reviews_count }} {{ Str::plural('review', $listing->reviews_count) }}
                    </h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach ($listing->reviews->take(4) as $review)
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-fog flex items-center justify-center text-xs font-semibold text-ink shrink-0">
                                {{ strtoupper(substr($review->user->first_name, 0, 1)) }}{{ strtoupper(substr($review->user->last_name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-ink">{{ $review->user->first_name }} {{ substr($review->user->last_name, 0, 1) }}.</p>
                                <p class="text-xs text-silver">{{ $review->created_at->format('F Y') }}</p>
                            </div>
                        </div>
                        <div class="flex gap-0.5 mb-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-ink' : 'text-fog' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="text-sm text-slate leading-relaxed">{{ $review->comment }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        {{-- ── RIGHT: booking widget ── --}}
        <div class="w-full lg:w-80 xl:w-96 shrink-0">
            <div class="sticky top-24 bg-white border border-fog rounded-2xl p-6 shadow-sm">

                <div class="flex items-baseline gap-1 mb-5">
                    <span class="font-display text-3xl font-bold text-ink">${{ number_format($listing->price_per_night / 100, 0) }}</span>
                    <span class="text-sm text-silver">/ night</span>
                </div>

                {{-- Validation errors from redirect back --}}
                @if ($errors->any())
                <div class="mb-4">
                    @foreach ($errors->all() as $error)
                    <p class="text-xs text-red-500 bg-red-50 rounded-xl px-3 py-2 mb-1">{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                @auth
                <form action="{{ route('bookings.create') }}" method="GET" id="booking-form" class="flex flex-col gap-4">
                    <input type="hidden" name="listing_id" value="{{ $listing->id }}" />

                    <div id="date-box" class="border border-fog rounded-xl overflow-hidden transition-colors">
                        <div class="grid grid-cols-2 divide-x divide-fog">
                            <div class="px-3 py-2.5">
                                <p class="text-[10px] uppercase tracking-widest text-silver font-medium">Check-in</p>
                                <input
                                    autocomplete="off"
                                    type="date"
                                    name="check_in"
                                    id="check_in"
                                    min="{{ date('Y-m-d') }}"
                                    class="w-full text-sm text-ink bg-transparent focus:outline-none mt-0.5 cursor-pointer"
                                />
                            </div>
                            <div class="px-3 py-2.5">
                                <p class="text-[10px] uppercase tracking-widest text-silver font-medium">Check-out</p>
                                <input
                                    autocomplete="off"
                                    type="date"
                                    name="check_out"
                                    id="check_out"
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    class="w-full text-sm text-ink bg-transparent focus:outline-none mt-0.5 cursor-pointer"
                                />
                            </div>
                        </div>
                        <div class="border-t border-fog px-3 py-2.5">
                            <p class="text-[10px] uppercase tracking-widest text-silver font-medium">Guests</p>
                            <select name="guests" class="w-full text-sm text-ink bg-transparent focus:outline-none mt-0.5 cursor-pointer">
                                @for ($i = 1; $i <= $listing->max_guests; $i++)
                                    <option value="{{ $i }}">{{ $i }} {{ Str::plural('guest', $i) }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <p id="date-error" class="text-xs text-red-500 -mt-2 hidden">Please select both check-in and check-out dates.</p>

                    <button type="submit" class="w-full bg-ink text-white font-medium text-sm rounded-xl py-3.5 hover:bg-carbon transition-colors">
                        Continue to payment
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="block w-full text-center bg-ink text-white font-medium text-sm rounded-xl py-3.5 hover:bg-carbon transition-colors">
                    Log in to reserve
                </a>
                @endauth

                <p class="text-center text-xs text-silver mt-3">You won't be charged yet</p>

                <div class="mt-5 pt-5 border-t border-fog flex flex-col gap-2.5 text-sm">
                    <div class="flex justify-between text-slate">
                        <span>${{ number_format($listing->price_per_night / 100, 0) }} &times; night</span>
                        <span>varies</span>
                    </div>
                    <div class="flex justify-between text-slate">
                        <span>Cleaning fee</span>
                        <span>${{ number_format($listing->cleaning_fee / 100, 0) }}</span>
                    </div>
                    <div class="flex justify-between font-semibold text-ink pt-2.5 border-t border-fog">
                        <span>Total</span>
                        <span>calculated at checkout</span>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
    const form     = document.getElementById('booking-form');
    const checkIn  = document.getElementById('check_in');
    const checkOut = document.getElementById('check_out');
    const dateBox  = document.getElementById('date-box');
    const dateErr  = document.getElementById('date-error');

    if (form) {
        checkIn.addEventListener('change', () => {
            if (checkIn.value) {
                const next = new Date(checkIn.value);
                next.setDate(next.getDate() + 1);
                checkOut.min = next.toISOString().split('T')[0];
                if (checkOut.value && checkOut.value <= checkIn.value) {
                    checkOut.value = '';
                }
            }
        });

        form.addEventListener('submit', (e) => {
            if (!checkIn.value || !checkOut.value) {
                e.preventDefault();
                dateBox.classList.remove('border-fog');
                dateBox.classList.add('border-red-400');
                dateErr.classList.remove('hidden');
                if (!checkIn.value) checkIn.focus();
            }
        });
    }
</script>
@endsection