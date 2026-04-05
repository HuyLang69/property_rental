@extends('layout')

@section('title', 'Booking Confirmed — NestAway')

@section('content')

<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

    @if (session('success'))
    <div class="flex items-center gap-3 bg-white border border-fog rounded-2xl p-4 mb-8">
        <div class="w-8 h-8 rounded-full bg-ink flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <p class="text-sm font-medium text-ink">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white border border-fog rounded-2xl overflow-hidden">

        {{-- Header --}}
        <div class="bg-ink text-white px-6 py-8 text-center">
            <svg class="w-10 h-10 text-white/60 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h1 class="font-display text-3xl font-bold mb-1">You're booked!</h1>
            <p class="text-white/60 text-sm">Booking #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
        </div>

        {{-- Listing summary --}}
        <div class="p-6 border-b border-fog flex items-center gap-4">
            <div class="w-20 h-16 rounded-xl overflow-hidden bg-fog shrink-0">
                @if ($booking->listing->coverImage)
                    <img src="{{ $booking->listing->coverImage->url }}" 
                         alt="{{ $booking->listing->title }}"
                         class="w-full h-full object-cover"
                         onerror="this.src='https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=200&h=160&fit=crop'">
                @else
                    <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=200&h=160&fit=crop" 
                         alt="Property"
                         class="w-full h-full object-cover">
                @endif
            </div>
            <div>
                <p class="font-semibold text-ink">{{ $booking->listing->title }}</p>
                <p class="text-xs text-silver mt-0.5">{{ $booking->listing->city }}, {{ $booking->listing->country }}</p>
                <p class="text-xs text-slate mt-1">Hosted by {{ $booking->listing->host->full_name }}</p>
            </div>
        </div>

        {{-- Booking details --}}
        <div class="p-6 grid grid-cols-2 gap-5 border-b border-fog">
            <div>
                <p class="text-xs uppercase tracking-widest text-silver mb-1">Check-in</p>
                <p class="text-sm font-semibold text-ink">{{ $booking->check_in->format('D, M d, Y') }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-widest text-silver mb-1">Check-out</p>
                <p class="text-sm font-semibold text-ink">{{ $booking->check_out->format('D, M d, Y') }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-widest text-silver mb-1">Guests</p>
                <p class="text-sm font-semibold text-ink">{{ $booking->guests }} {{ Str::plural('guest', $booking->guests) }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-widest text-silver mb-1">Status</p>
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full
                    {{ $booking->status === 'confirmed' ? 'bg-ink text-white' : '' }}
                    {{ $booking->status === 'pending'   ? 'bg-fog text-slate' : '' }}
                    {{ $booking->status === 'cancelled' ? 'bg-red-50 text-red-500' : '' }}">
                    {{ ucfirst($booking->status) }}
                </span>
            </div>
        </div>

        {{-- Price breakdown --}}
        <div class="p-6 border-b border-fog flex flex-col gap-2.5 text-sm">
            <div class="flex justify-between text-slate">
                <span>${{ number_format($booking->price_per_night / 100, 2) }} &times; {{ $booking->nights }} {{ Str::plural('night', $booking->nights) }}</span>
                <span>${{ number_format(($booking->price_per_night * $booking->nights) / 100, 2) }}</span>
            </div>
            <div class="flex justify-between text-slate">
                <span>Cleaning fee</span>
                <span>${{ number_format($booking->cleaning_fee / 100, 2) }}</span>
            </div>
            <div class="flex justify-between text-slate">
                <span>Service fee</span>
                <span>${{ number_format($booking->service_fee / 100, 2) }}</span>
            </div>
            <div class="flex justify-between font-semibold text-ink pt-2.5 border-t border-fog">
                <span>Total charged</span>
                <span>${{ number_format($booking->total / 100, 2) }}</span>
            </div>
        </div>

        {{-- Actions --}}
        <div class="p-6 flex flex-col sm:flex-row gap-3">
            <a href="{{ route('dashboard.bookings') }}"
               class="flex-1 text-center bg-ink text-white text-sm font-medium rounded-xl py-3 hover:bg-carbon transition-colors">
                View my trips
            </a>
            @if ($booking->status !== 'cancelled')
            <button type="button"
                    onclick="openModal('cancel-modal')"
                    class="flex-1 border border-fog text-sm font-medium rounded-xl py-3 text-slate hover:border-red-300 hover:text-red-400 transition-colors">
                Cancel booking
            </button>
            @endif
        </div>

    </div>
</div>

{{-- Cancel modal --}}
@if ($booking->status !== 'cancelled')
<div id="cancel-modal" class="fixed inset-0 z-50 hidden items-center justify-center px-4">
    <div class="absolute inset-0 bg-ink/40 backdrop-blur-sm" onclick="closeModal('cancel-modal')"></div>
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 flex flex-col gap-5">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-ink">Cancel this booking?</h3>
                <p class="text-sm text-slate mt-1 leading-relaxed">
                    {{ $booking->listing->title }}<br>
                    {{ $booking->check_in->format('M d') }} – {{ $booking->check_out->format('M d, Y') }}
                </p>
                <p class="text-xs text-silver mt-2">This action cannot be undone.</p>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="button"
                    onclick="closeModal('cancel-modal')"
                    class="flex-1 border border-fog rounded-xl py-2.5 text-sm font-medium text-slate hover:border-ink hover:text-ink transition-colors">
                Keep booking
            </button>
            <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" class="flex-1">
                @csrf
                @method('PATCH')
                <button type="submit"
                        class="w-full bg-red-500 text-white rounded-xl py-2.5 text-sm font-medium hover:bg-red-600 transition-colors">
                    Yes, cancel
                </button>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
    function openModal(id) {
        const m = document.getElementById(id);
        m.classList.remove('hidden');
        m.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        const m = document.getElementById(id);
        m.classList.add('hidden');
        m.classList.remove('flex');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeModal('cancel-modal');
    });
</script>
@endsection