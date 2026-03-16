@extends('layout')

@section('title', 'Incoming Bookings — NestAway')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @include('host._nav')

    @if (session('success'))
    <div class="flex items-center gap-3 bg-white border border-fog rounded-2xl px-4 py-3 mb-6">
        <svg class="w-4 h-4 text-ink shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        <p class="text-sm text-ink">{{ session('success') }}</p>
    </div>
    @endif

    @if (session('error'))
    <div class="flex items-center gap-3 bg-red-50 border border-red-100 rounded-2xl px-4 py-3 mb-6">
        <p class="text-sm text-red-500">{{ session('error') }}</p>
    </div>
    @endif

    {{-- Filters --}}
    <form method="GET" action="{{ route('host.bookings') }}"
          class="flex flex-wrap items-center gap-3 mb-6">

        <select name="status" onchange="this.form.submit()"
                class="border border-fog rounded-xl px-3 py-2 text-sm text-ink bg-white focus:border-ink focus:outline-none transition-colors">
            <option value="all"       {{ $status === 'all'       ? 'selected' : '' }}>All statuses</option>
            <option value="confirmed" {{ $status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="pending"   {{ $status === 'pending'   ? 'selected' : '' }}>Pending</option>
            <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>

        <select name="listing_id" onchange="this.form.submit()"
                class="border border-fog rounded-xl px-3 py-2 text-sm text-ink bg-white focus:border-ink focus:outline-none transition-colors">
            <option value="">All listings</option>
            @foreach ($listings as $l)
            <option value="{{ $l->id }}" {{ $listingFilter == $l->id ? 'selected' : '' }}>
                {{ Str::limit($l->title, 40) }}
            </option>
            @endforeach
        </select>

        @if ($status !== 'all' || $listingFilter)
        <a href="{{ route('host.bookings') }}"
           class="text-xs text-silver hover:text-ink transition-colors">
            Clear filters
        </a>
        @endif

        <span class="text-xs text-silver ml-auto">{{ $bookings->count() }} {{ Str::plural('booking', $bookings->count()) }}</span>
    </form>

    @if ($bookings->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <svg class="w-12 h-12 text-fog mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/>
            </svg>
            <p class="font-semibold text-ink mb-1">No bookings yet</p>
            <p class="text-sm text-silver">Bookings for your listings will appear here.</p>
        </div>
    @else
        <div class="flex flex-col gap-4">
            @foreach ($bookings as $booking)
            <div class="bg-white border border-fog rounded-2xl p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">

                <div class="flex items-start gap-4 flex-1 min-w-0">
                    {{-- Guest avatar --}}
                    <div class="w-10 h-10 rounded-full bg-fog flex items-center justify-center text-xs font-semibold text-ink shrink-0">
                        {{ strtoupper(substr($booking->user->first_name, 0, 1)) }}{{ strtoupper(substr($booking->user->last_name, 0, 1)) }}
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[10px] uppercase tracking-widest font-semibold px-2.5 py-1 rounded-full
                                {{ $booking->status === 'confirmed' ? 'bg-ink text-white' : '' }}
                                {{ $booking->status === 'pending'   ? 'bg-fog text-slate' : '' }}
                                {{ $booking->status === 'cancelled' ? 'bg-red-50 text-red-400' : '' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                        <p class="font-semibold text-ink text-sm">
                            {{ $booking->user->first_name }} {{ $booking->user->last_name }}
                        </p>
                        <p class="text-xs text-silver mt-0.5 truncate">{{ $booking->listing->title }}</p>
                        <p class="text-xs text-slate mt-1.5 flex flex-wrap gap-x-2">
                            <span>{{ $booking->check_in->format('M d, Y') }} → {{ $booking->check_out->format('M d, Y') }}</span>
                            <span>· {{ $booking->nights }} {{ Str::plural('night', $booking->nights) }}</span>
                            <span>· {{ $booking->guests }} {{ Str::plural('guest', $booking->guests) }}</span>
                        </p>
                    </div>
                </div>

                <div class="flex flex-col items-start sm:items-end gap-3 shrink-0">
                    <p class="text-sm font-bold text-ink">${{ number_format($booking->total / 100, 2) }}</p>
                    <div class="flex gap-2">
                        <a href="{{ route('bookings.show', $booking->id) }}"
                           class="text-xs font-medium border border-fog rounded-full px-3 py-1.5 hover:border-ink transition-colors">
                            View
                        </a>
                        @if ($booking->status !== 'cancelled')
                        <button type="button"
                                onclick="openModal('hmodal-{{ $booking->id }}')"
                                class="text-xs font-medium border border-fog rounded-full px-3 py-1.5 text-slate hover:border-red-300 hover:text-red-400 transition-colors">
                            Cancel
                        </button>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Cancel modal --}}
            @if ($booking->status !== 'cancelled')
            <div id="hmodal-{{ $booking->id }}" class="fixed inset-0 z-50 hidden items-center justify-center px-4">
                <div class="absolute inset-0 bg-ink/40 backdrop-blur-sm"
                     onclick="closeModal('hmodal-{{ $booking->id }}')"></div>
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
                                {{ $booking->user->first_name }} {{ $booking->user->last_name }}<br>
                                {{ $booking->check_in->format('M d') }} – {{ $booking->check_out->format('M d, Y') }}
                            </p>
                            <p class="text-xs text-silver mt-2">This action cannot be undone.</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="button"
                                onclick="closeModal('hmodal-{{ $booking->id }}')"
                                class="flex-1 border border-fog rounded-xl py-2.5 text-sm font-medium text-slate hover:border-ink hover:text-ink transition-colors">
                            Keep booking
                        </button>
                        <form action="{{ route('host.cancel', $booking->id) }}" method="POST" class="flex-1">
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

            @endforeach
        </div>
    @endif

</div>

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
        if (e.key !== 'Escape') return;
        document.querySelectorAll('[id^="hmodal-"]').forEach(m => {
            m.classList.add('hidden');
            m.classList.remove('flex');
        });
        document.body.style.overflow = '';
    });
</script>
@endsection