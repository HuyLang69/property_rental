@extends('layout')

@section('title', 'Earnings — NestAway')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @include('host._nav')

    {{-- Summary cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10">
        <div class="bg-ink text-white rounded-2xl p-6">
            <p class="text-xs uppercase tracking-widest text-white/50 mb-2">Total earnings</p>
            <p class="font-display text-4xl font-bold">${{ number_format($totalRevenue / 100, 2) }}</p>
            <p class="text-xs text-white/50 mt-1">from confirmed bookings</p>
        </div>
        <div class="bg-white border border-fog rounded-2xl p-6">
            <p class="text-xs uppercase tracking-widest text-silver mb-2">Confirmed bookings</p>
            <p class="font-display text-4xl font-bold text-ink">{{ $totalBookings }}</p>
            <p class="text-xs text-silver mt-1">across all listings</p>
        </div>
        <div class="bg-white border border-fog rounded-2xl p-6">
            <p class="text-xs uppercase tracking-widest text-silver mb-2">Active listings</p>
            <p class="font-display text-4xl font-bold text-ink">{{ $listingsWithRevenue->count() }}</p>
            <p class="text-xs text-silver mt-1">properties listed</p>
        </div>
    </div>

    {{-- Per-listing breakdown --}}
    <div class="bg-white border border-fog rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-fog">
            <h2 class="text-sm font-semibold text-ink uppercase tracking-widest">Per-listing breakdown</h2>
        </div>

        @if ($listingsWithRevenue->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <p class="font-semibold text-ink mb-1">No listings yet</p>
                <p class="text-sm text-silver mb-6">Create a listing to start earning.</p>
                <a href="{{ route('listings.create') }}"
                   class="bg-ink text-white text-sm font-medium rounded-full px-6 py-3 hover:bg-carbon transition-colors">
                    Create a listing
                </a>
            </div>
        @else
            <div class="divide-y divide-fog">
                @foreach ($listingsWithRevenue as $listing)
                <div class="flex items-center justify-between gap-4 px-6 py-4">
                    <div class="flex items-center gap-4 flex-1 min-w-0">
                        <div class="w-12 h-10 rounded-lg overflow-hidden bg-fog shrink-0">
                            @if ($listing->coverImage)
                                <img src="{{ $listing->coverImage->path }}" class="w-full h-full object-cover" />
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-ink truncate">{{ $listing->title }}</p>
                            <p class="text-xs text-silver mt-0.5">
                                {{ $listing->city }} &middot;
                                {{ $listing->booking_count }} {{ Str::plural('booking', $listing->booking_count) }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-sm font-bold text-ink">${{ number_format($listing->revenue / 100, 2) }}</p>
                        <p class="text-xs text-silver mt-0.5">${{ number_format($listing->price_per_night / 100, 0) }}/night</p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Total row --}}
            <div class="flex items-center justify-between px-6 py-4 border-t border-fog bg-cream">
                <p class="text-sm font-semibold text-ink">Total</p>
                <p class="text-sm font-bold text-ink">${{ number_format($totalRevenue / 100, 2) }}</p>
            </div>
        @endif
    </div>

</div>
@endsection