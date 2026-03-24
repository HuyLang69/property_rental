{{-- resources/views/admin/_nav.blade.php --}}
<div class="flex items-center justify-between mb-8">
    <div>
        <p class="text-xs uppercase tracking-widest text-silver mb-1">Admin</p>
        <h1 class="font-display text-3xl font-bold tracking-tight text-ink">Admin Dashboard</h1>
    </div>
</div>

<div class="flex gap-1 mb-8 border-b border-fog overflow-x-auto">
    <a href="{{ route('admin.dashboard') }}"
       class="whitespace-nowrap px-4 py-2.5 text-sm font-medium transition-colors border-b-2 -mb-px
              {{ request()->routeIs('admin.dashboard') ? 'border-ink text-ink' : 'border-transparent text-silver hover:text-ink' }}">
        Overview
    </a>
    <a href="{{ route('admin.users') }}"
       class="whitespace-nowrap px-4 py-2.5 text-sm font-medium transition-colors border-b-2 -mb-px
              {{ request()->routeIs('admin.users') ? 'border-ink text-ink' : 'border-transparent text-silver hover:text-ink' }}">
        Users
    </a>
    <a href="{{ route('admin.listings') }}"
       class="whitespace-nowrap px-4 py-2.5 text-sm font-medium transition-colors border-b-2 -mb-px
              {{ request()->routeIs('admin.listings') ? 'border-ink text-ink' : 'border-transparent text-silver hover:text-ink' }}">
        Listings
    </a>
    <a href="{{ route('admin.bookings') }}"
       class="whitespace-nowrap px-4 py-2.5 text-sm font-medium transition-colors border-b-2 -mb-px
              {{ request()->routeIs('admin.bookings') ? 'border-ink text-ink' : 'border-transparent text-silver hover:text-ink' }}">
        Bookings
    </a>
</div>
