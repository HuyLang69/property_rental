@extends('layout')

@section('title', 'Leave a Review — NestAway')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <div class="mb-8">
        <a href="{{ route('dashboard.bookings') }}"
           class="flex items-center gap-2 text-sm text-silver hover:text-ink transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
            </svg>
            Back to my trips
        </a>
        <p class="text-xs uppercase tracking-widest text-silver mb-1">Share your experience</p>
        <h1 class="font-display text-3xl font-bold tracking-tight text-ink">Leave a review</h1>
    </div>

    {{-- Listing summary --}}
    <div class="bg-white border border-fog rounded-2xl p-5 mb-6 flex items-center gap-4">
        <div class="w-20 h-16 rounded-xl overflow-hidden shrink-0 bg-fog">
            @if ($booking->listing->coverImage)
                <img src="{{ $booking->listing->coverImage->path }}" class="w-full h-full object-cover" />
            @endif
        </div>
        <div class="flex-1 min-w-0">
            <p class="font-semibold text-ink truncate">{{ $booking->listing->title }}</p>
            <p class="text-xs text-silver mt-0.5">{{ $booking->listing->city }}, {{ $booking->listing->country }}</p>
            <p class="text-xs text-slate mt-1">
                {{ $booking->check_in->format('M d') }} – {{ $booking->check_out->format('M d, Y') }}
                · {{ $booking->nights }} {{ Str::plural('night', $booking->nights) }}
            </p>
        </div>
    </div>

    <form action="{{ route('reviews.store', $booking->id) }}" method="POST" class="flex flex-col gap-6">
        @csrf

        {{-- Star rating --}}
        <div class="bg-white border border-fog rounded-2xl p-6 flex flex-col gap-4">
            <h2 class="text-sm font-semibold text-ink uppercase tracking-widest">Overall rating</h2>

            <div class="flex items-center gap-2" id="star-container">
                @for ($i = 1; $i <= 5; $i++)
                <button type="button"
                        data-value="{{ $i }}"
                        class="star-btn text-fog hover:text-ink transition-colors"
                        onclick="setRating({{ $i }})">
                    <svg class="w-9 h-9" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </button>
                @endfor
            </div>

            <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}" />
            <p id="rating-label" class="text-sm text-silver h-5"></p>

            @error('rating')
                <p class="text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Comment --}}
        <div class="bg-white border border-fog rounded-2xl p-6 flex flex-col gap-4">
            <h2 class="text-sm font-semibold text-ink uppercase tracking-widest">Your review</h2>
            <textarea
                autocomplete="off"
                name="comment"
                id="comment"
                rows="5"
                placeholder="Tell future guests what you loved, what could be improved, and anything else worth knowing…"
                class="border border-fog rounded-xl px-4 py-3 text-sm text-ink placeholder-silver bg-cream focus:border-ink focus:outline-none transition-colors resize-none"
            >{{ old('comment') }}</textarea>
            <div class="flex justify-between items-center">
                @error('comment')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @else
                    <p class="text-xs text-silver">Min. 10 characters</p>
                @enderror
                <p id="char-count" class="text-xs text-silver ml-auto">0 / 1000</p>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('dashboard.bookings') }}"
               class="text-sm text-silver hover:text-ink transition-colors">
                Cancel
            </a>
            <button type="submit"
                    class="bg-ink text-white text-sm font-medium rounded-full px-8 py-3 hover:bg-carbon transition-colors">
                Submit review
            </button>
        </div>

    </form>
</div>
@endsection

@section('scripts')
<script>
    const labels = ['', 'Poor', 'Fair', 'Good', 'Very good', 'Excellent'];
    const stars  = document.querySelectorAll('.star-btn');
    const input  = document.getElementById('rating-input');
    const label  = document.getElementById('rating-label');

    // Restore old value if validation failed
    if (input.value) setRating(parseInt(input.value));

    function setRating(val) {
        input.value = val;
        label.textContent = labels[val];
        stars.forEach(s => {
            const v = parseInt(s.dataset.value);
            s.classList.toggle('text-ink', v <= val);
            s.classList.toggle('text-fog', v > val);
        });
    }

    // Hover preview
    stars.forEach(s => {
        s.addEventListener('mouseenter', () => {
            const v = parseInt(s.dataset.value);
            stars.forEach(s2 => {
                s2.classList.toggle('text-ink', parseInt(s2.dataset.value) <= v);
                s2.classList.toggle('text-fog',  parseInt(s2.dataset.value) > v);
            });
            label.textContent = labels[v];
        });
        s.addEventListener('mouseleave', () => {
            const cur = parseInt(input.value) || 0;
            stars.forEach(s2 => {
                s2.classList.toggle('text-ink', parseInt(s2.dataset.value) <= cur);
                s2.classList.toggle('text-fog',  parseInt(s2.dataset.value) > cur);
            });
            label.textContent = cur ? labels[cur] : '';
        });
    });

    // Character counter
    const textarea  = document.getElementById('comment');
    const charCount = document.getElementById('char-count');
    textarea.addEventListener('input', () => {
        charCount.textContent = `${textarea.value.length} / 1000`;
    });
    charCount.textContent = `${textarea.value.length} / 1000`;
</script>
@endsection