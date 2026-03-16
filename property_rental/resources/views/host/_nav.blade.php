{{-- resources/views/host/_nav.blade.php --}}
<div class="flex items-center justify-between mb-8">
    <div>
        <p class="text-xs uppercase tracking-widest text-silver mb-1">Host</p>
        <h1 class="font-display text-3xl font-bold tracking-tight text-ink">Host Dashboard</h1>
    </div>
    <a href="{{ route('listings.create') }}"
       class="flex items-center gap-2 bg-ink text-white text-sm font-medium rounded-full px-5 py-2.5 hover:bg-carbon transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        New listing
    </a>
</div>

<div class="flex gap-1 mb-8 border-b border-fog overflow-x-auto">
    <a href="{{ route('host.bookings') }}"
       class="whitespace-nowrap px-4 py-2.5 text-sm font-medium transition-colors border-b-2 -mb-px
              {{ request()->routeIs('host.bookings') ? 'border-ink text-ink' : 'border-transparent text-silver hover:text-ink' }}">
        Bookings
    </a>
    <a href="{{ route('host.earnings') }}"
       class="whitespace-nowrap px-4 py-2.5 text-sm font-medium transition-colors border-b-2 -mb-px
              {{ request()->routeIs('host.earnings') ? 'border-ink text-ink' : 'border-transparent text-silver hover:text-ink' }}">
        Earnings
    </a>
    <a href="{{ route('host.reviews') }}"
       class="whitespace-nowrap px-4 py-2.5 text-sm font-medium transition-colors border-b-2 -mb-px
              {{ request()->routeIs('host.reviews') ? 'border-ink text-ink' : 'border-transparent text-silver hover:text-ink' }}">
        Reviews
    </a>
    <a href="{{ route('dashboard.listings') }}"
       class="whitespace-nowrap px-4 py-2.5 text-sm font-medium transition-colors border-b-2 -mb-px
              {{ request()->routeIs('dashboard.listings') ? 'border-ink text-ink' : 'border-transparent text-silver hover:text-ink' }}">
        My listings
    </a>
</div>