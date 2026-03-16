@extends('layout')

@section('title', 'My Listings — NestAway')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @include('dashboard._nav')

    @if (session('success'))
    <div class="flex items-center gap-3 bg-white border border-fog rounded-2xl px-4 py-3 mb-6">
        <svg class="w-4 h-4 text-ink shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        <p class="text-sm text-ink">{{ session('success') }}</p>
    </div>
    @endif

    @if ($listings->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <svg class="w-12 h-12 text-fog mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 012.092 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75"/>
            </svg>
            <p class="font-semibold text-ink mb-1">No listings yet</p>
            <p class="text-sm text-silver mb-6">List your first property and start earning.</p>
            <a href="{{ route('listings.create') }}"
               class="bg-ink text-white text-sm font-medium rounded-full px-6 py-3 hover:bg-carbon transition-colors">
                Create a listing
            </a>
        </div>
    @else
        <div class="flex flex-col gap-4">
            @foreach ($listings as $listing)
            <div class="bg-white border border-fog rounded-2xl overflow-hidden flex flex-col sm:flex-row">

                <div class="w-full sm:w-44 h-40 sm:h-auto shrink-0 bg-fog overflow-hidden">
                    @if ($listing->coverImage)
                        <img src="{{ $listing->coverImage->path }}" alt="{{ $listing->title }}" class="w-full h-full object-cover" />
                    @else
                        <div class="w-full h-full bg-fog flex items-center justify-center">
                            <svg class="w-8 h-8 text-silver" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="flex flex-1 flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-5">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs text-silver uppercase tracking-widest">{{ ucfirst($listing->type) }}</span>
                            <span class="w-1 h-1 rounded-full bg-fog"></span>
                            <span class="text-[10px] uppercase tracking-widest font-semibold px-2.5 py-1 rounded-full
                                {{ $listing->is_available ? 'bg-ink text-white' : 'bg-fog text-slate' }}">
                                {{ $listing->is_available ? 'Active' : 'Hidden' }}
                            </span>
                        </div>
                        <h3 class="font-semibold text-ink leading-snug">{{ $listing->title }}</h3>
                        <p class="text-xs text-silver mt-0.5">{{ $listing->city }}, {{ $listing->country }}</p>
                        <p class="text-xs text-slate mt-2 flex flex-wrap gap-x-2">
                            <span>${{ number_format($listing->price_per_night / 100, 0) }}/night</span>
                            <span>· {{ $listing->bookings_count }} {{ Str::plural('booking', $listing->bookings_count) }}</span>
                            <span>· {{ $listing->bedrooms }} {{ Str::plural('bed', $listing->bedrooms) }}</span>
                        </p>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('listings.show', $listing->id) }}"
                           class="text-xs font-medium border border-fog rounded-full px-3 py-1.5 hover:border-ink transition-colors">
                            View
                        </a>
                        <a href="{{ route('listings.edit', $listing->id) }}"
                           class="text-xs font-medium border border-fog rounded-full px-3 py-1.5 hover:border-ink transition-colors">
                            Edit
                        </a>
                        <form action="{{ route('listings.destroy', $listing->id) }}" method="POST"
                              onsubmit="return confirm('Permanently delete this listing?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-xs font-medium border border-fog rounded-full px-3 py-1.5 text-slate hover:border-red-300 hover:text-red-400 transition-colors">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

            </div>
            @endforeach
        </div>
    @endif

</div>
@endsection