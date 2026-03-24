{{-- resources/views/dashboard/_nav.blade.php --}}
<div class="flex items-start sm:items-center justify-between gap-4 flex-wrap mb-8">
    <div class="flex-1 min-w-0">
        <p class="text-xs uppercase tracking-widest text-silver mb-1">Account</p>
        <h1 class="font-display text-3xl font-bold tracking-tight text-ink">Dashboard</h1>
    </div>
    <a href="{{ route('listings.create') }}"
       class="flex items-center gap-2 bg-ink text-white text-sm font-medium rounded-full px-5 py-2.5 hover:bg-carbon transition-colors shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        New listing
    </a>
</div>

<div class="flex gap-1 mb-8 border-b border-fog">
    <a href="{{ route('dashboard.bookings') }}"
       class="px-4 py-2.5 text-sm font-medium transition-colors border-b-2 -mb-px
              {{ request()->routeIs('dashboard.bookings') ? 'border-ink text-ink' : 'border-transparent text-silver hover:text-ink' }}">
        My trips
    </a>
</div>