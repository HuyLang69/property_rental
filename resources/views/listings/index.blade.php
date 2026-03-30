@extends('layout')

@section('title', 'All Listings — NestAway')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8">
        <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-ink">All listings</h1>
        <p class="text-sm text-silver mt-1">{{ $listings->total() }} {{ Str::plural('property', $listings->total()) }} found</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- ── SIDEBAR FILTERS ── --}}
        <aside class="w-full lg:w-64 shrink-0">
            <form action="{{ route('listings.index') }}" method="GET" class="flex flex-col gap-6 bg-white border border-fog rounded-2xl p-6 sticky top-24">

                <h2 class="font-semibold text-sm text-ink uppercase tracking-widest">Filters</h2>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs text-slate uppercase tracking-widest font-medium">Location</label>
                    <input autocomplete="off" type="text" name="search" placeholder="City or address…"
                           value="{{ request('search') }}"
                           class="border border-fog rounded-xl px-3 py-2.5 text-sm text-ink placeholder-silver bg-cream focus:border-ink focus:outline-none transition-colors" />
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs text-slate uppercase tracking-widest font-medium">Type</label>
                    <div class="flex flex-col gap-2">
                        @foreach (['any' => 'Any', 'apartment' => 'Apartment', 'house' => 'House', 'studio' => 'Studio', 'villa' => 'Villa', 'room' => 'Room'] as $value => $label)
                        <label class="flex items-center gap-2 text-sm text-slate cursor-pointer">
                            <input type="radio" name="type" value="{{ $value === 'any' ? '' : $value }}" class="accent-ink"
                                {{ request('type', '') === ($value === 'any' ? '' : $value) ? 'checked' : '' }} />
                            {{ $label }}
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs text-slate uppercase tracking-widest font-medium">Price / night ($)</label>
                    <div class="flex items-center gap-2">
                        <input autocomplete="off" type="number" name="price_min" placeholder="Min"
                               value="{{ request('price_min') }}"
                               class="w-full border border-fog rounded-xl px-3 py-2.5 text-sm text-ink placeholder-silver bg-cream focus:border-ink focus:outline-none transition-colors" />
                        <span class="text-silver text-sm shrink-0">—</span>
                        <input autocomplete="off" type="number" name="price_max" placeholder="Max"
                               value="{{ request('price_max') }}"
                               class="w-full border border-fog rounded-xl px-3 py-2.5 text-sm text-ink placeholder-silver bg-cream focus:border-ink focus:outline-none transition-colors" />
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs text-slate uppercase tracking-widest font-medium">Min. beds</label>
                    <select name="beds" class="border border-fog rounded-xl px-3 py-2.5 text-sm text-ink bg-cream focus:border-ink focus:outline-none transition-colors">
                        <option value="">Any</option>
                        @foreach ([1, 2, 3, 4] as $n)
                        <option value="{{ $n }}" {{ request('beds') == $n ? 'selected' : '' }}>{{ $n }}+</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-2 pt-1 border-t border-fog">
                    <button type="submit" class="w-full bg-ink text-white text-sm font-medium rounded-xl py-2.5 hover:bg-carbon transition-colors">
                        Apply filters
                    </button>
                    <a href="{{ route('listings.index') }}" class="w-full text-center text-sm text-silver hover:text-ink transition-colors py-1">
                        Clear all
                    </a>
                </div>

            </form>
        </aside>

        {{-- ── LISTINGS GRID ── --}}
        <div class="flex-1">

            <div class="flex items-center justify-between mb-6">
                <p class="text-sm text-silver">{{ $listings->total() }} results</p>
                <form action="{{ route('listings.index') }}" method="GET" id="sort-form">
                    @foreach (request()->except('sort') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}" />
                    @endforeach
                    <select name="sort" onchange="document.getElementById('sort-form').submit()"
                            class="border border-fog rounded-xl px-3 py-2 text-sm text-ink bg-white focus:border-ink focus:outline-none transition-colors">
                        <option value="newest"     {{ request('sort', 'newest') === 'newest'     ? 'selected' : '' }}>Newest first</option>
                        <option value="price_asc"  {{ request('sort') === 'price_asc'            ? 'selected' : '' }}>Price: low to high</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc'           ? 'selected' : '' }}>Price: high to low</option>
                        <option value="rating"     {{ request('sort') === 'rating'               ? 'selected' : '' }}>Top rated</option>
                    </select>
                </form>
            </div>

            @if ($listings->isEmpty())
                <div class="flex flex-col items-center justify-center py-24 text-center">
                    <svg class="w-12 h-12 text-fog mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 012.092 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75"/>
                    </svg>
                    <p class="text-ink font-semibold mb-1">No listings found</p>
                    <p class="text-sm text-silver mb-5">Try adjusting your filters.</p>
                    <a href="{{ route('listings.index') }}" class="text-sm font-medium border border-fog rounded-full px-5 py-2 hover:border-ink transition-colors">Clear filters</a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                    @foreach ($listings as $listing)
                    <a href="{{ route('listings.show', $listing->id) }}" class="lift group bg-white rounded-2xl overflow-hidden border border-fog flex flex-col">
                        <div class="img-zoom relative" style="aspect-ratio:4/3">
                            @if ($listing->coverImage)
                                <img src="{{ $listing->coverImage->url }}" alt="{{ $listing->title }}" class="w-full h-full object-cover" loading="lazy" />
                            @else
                                <div class="w-full h-full bg-fog flex items-center justify-center">
                                    <svg class="w-10 h-10 text-silver" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909"/></svg>
                                </div>
                            @endif
                            <span class="absolute top-3 left-3 bg-ink/75 backdrop-blur-sm text-white text-[10px] uppercase tracking-widest font-semibold rounded-full px-2.5 py-1">{{ $listing->type }}</span>
                        </div>
                        <div class="p-4 flex flex-col gap-2 flex-1">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-sm text-ink truncate">{{ $listing->title }}</h3>
                                    <p class="text-xs text-silver mt-0.5">{{ $listing->city }}, {{ $listing->country }}</p>
                                </div>
                                @if ($listing->reviews_avg_rating)
                                <div class="flex items-center gap-1 shrink-0 text-xs">
                                    <svg class="w-3.5 h-3.5 text-ink" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <span class="font-semibold text-ink">{{ number_format($listing->reviews_avg_rating, 1) }}</span>
                                </div>
                                @endif
                            </div>
                            <p class="text-xs text-slate">{{ $listing->bedrooms }} bed{{ $listing->bedrooms > 1 ? 's' : '' }} &middot; {{ $listing->type }}</p>
                            <p class="mt-auto text-sm font-bold text-ink">
                                ${{ number_format($listing->price_per_night / 100, 0) }}
                                <span class="text-xs font-normal text-silver">/ night</span>
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $listings->links() }}
                </div>
            @endif

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