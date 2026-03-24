@extends('layout')

@section('title', 'Admin Bookings — NestAway')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @include('admin._nav')

    <div class="bg-white border border-fog rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate">
                <thead class="bg-cream text-xs uppercase tracking-widest text-ink font-semibold">
                    <tr>
                        <th class="px-6 py-4">Guest</th>
                        <th class="px-6 py-4">Listing</th>
                        <th class="px-6 py-4">Dates</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-fog">
                    @foreach ($bookings as $booking)
                    <tr class="hover:bg-fog/30 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-ink">{{ $booking->guest->full_name }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('listings.show', $booking->listing->id) }}" class="text-ink font-medium hover:underline truncate inline-block w-40" title="{{ $booking->listing->title }}">
                                {{ $booking->listing->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p>{{ $booking->check_in->format('M d') }} - {{ $booking->check_out->format('M d, Y') }}</p>
                            <p class="text-xs text-silver mt-0.5">{{ $booking->nights }} nights</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-[10px] uppercase tracking-widest font-semibold px-2.5 py-1 rounded-full
                                {{ $booking->status === 'confirmed' ? 'bg-ink text-white' : '' }}
                                {{ $booking->status === 'pending'   ? 'bg-fog text-slate' : '' }}
                                {{ $booking->status === 'cancelled' ? 'bg-red-50 text-red-400' : '' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-semibold text-ink">
                            ${{ number_format($booking->total / 100, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $bookings->links() }}
    </div>

</div>
@endsection
