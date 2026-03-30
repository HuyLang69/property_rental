@extends('layout')

@section('title', 'Admin Dashboard — NestAway')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @include('admin._nav')

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        {{-- Total Users --}}
        <div class="bg-white border border-fog rounded-2xl p-6">
            <p class="text-sm font-medium text-slate mb-1">Total Users</p>
            <p class="font-display text-4xl font-bold text-ink">{{ number_format($stats['users']) }}</p>
        </div>

        {{-- Total Listings --}}
        <div class="bg-white border border-fog rounded-2xl p-6">
            <p class="text-sm font-medium text-slate mb-1">Total Listings</p>
            <p class="font-display text-4xl font-bold text-ink">{{ number_format($stats['listings']) }}</p>
        </div>

        {{-- Total Bookings --}}
        <div class="bg-white border border-fog rounded-2xl p-6">
            <p class="text-sm font-medium text-slate mb-1">Total Bookings</p>
            <p class="font-display text-4xl font-bold text-ink">{{ number_format($stats['bookings']) }}</p>
        </div>

        {{-- Total Revenue --}}
        <div class="bg-white border text-white bg-ink rounded-2xl p-6">
            <p class="text-sm font-medium text-gray-300 mb-1">Total Revenue</p>
            <p class="font-display text-4xl font-bold">${{ number_format($stats['revenue'] / 100, 2) }}</p>
        </div>
    </div>
</div>
@endsection
