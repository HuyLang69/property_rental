@extends('layout')

@section('title', 'Admin Listings — NestAway')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @include('admin._nav')

    @if (session('success'))
    <div class="flex items-center gap-3 bg-white border border-fog rounded-2xl px-4 py-3 mb-6">
        <svg class="w-4 h-4 text-ink shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        <p class="text-sm text-ink">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white border border-fog rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate">
                <thead class="bg-cream text-xs uppercase tracking-widest text-ink font-semibold">
                    <tr>
                        <th class="px-6 py-4">Listing</th>
                        <th class="px-6 py-4">Host</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-fog">
                    @foreach ($listings as $listing)
                    <tr class="hover:bg-fog/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-fog flex items-center justify-center shrink-0 overflow-hidden">
                                    @if ($listing->coverImage)
                                        <img src="{{ asset('storage/' . $listing->coverImage->path) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-silver" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-ink line-clamp-1 truncate w-48" title="{{ $listing->title }}">{{ $listing->title }}</p>
                                    <p class="text-xs text-silver mt-0.5">{{ $listing->city }}, {{ $listing->country }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-ink font-medium">{{ $listing->host->full_name }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if ($listing->is_available)
                                <span class="bg-ink text-white text-[10px] uppercase tracking-widest font-semibold px-2.5 py-1 rounded-full">Active</span>
                            @else
                                <span class="bg-fog text-slate text-[10px] uppercase tracking-widest font-semibold px-2.5 py-1 rounded-full">Hidden</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('admin.toggleListing', $listing->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="text-xs font-medium border border-fog rounded-full px-3 py-1.5 text-slate hover:border-ink hover:text-ink transition-colors">
                                        {{ $listing->is_available ? 'Hide' : 'Activate' }}
                                    </button>
                                </form>
                                <button type="button"
                                        onclick="openDeleteModal('del-listing-{{ $listing->id }}')"
                                        class="text-xs font-medium border border-fog rounded-full px-3 py-1.5 text-slate hover:border-red-300 hover:text-red-400 transition-colors">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $listings->links() }}
    </div>

    {{-- Delete modals --}}
    @foreach ($listings as $listing)
    <div id="del-listing-{{ $listing->id }}" class="fixed inset-0 z-50 hidden items-center justify-center px-4">
        <div class="absolute inset-0 bg-ink/40 backdrop-blur-sm"
             onclick="closeDeleteModal('del-listing-{{ $listing->id }}')">
        </div>
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 flex flex-col gap-5">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-ink">Delete this listing?</h3>
                    <p class="text-sm text-slate mt-1 leading-relaxed">{{ Str::limit($listing->title, 40) }}</p>
                    <p class="text-xs text-silver mt-2">All photos will be permanently removed. This cannot be undone.</p>
                </div>
            </div>
            <div class="flex gap-3">
                <button type="button"
                        onclick="closeDeleteModal('del-listing-{{ $listing->id }}')" 
                        class="flex-1 border border-fog rounded-xl py-2.5 text-sm font-medium text-slate
                               hover:border-ink hover:text-ink transition-colors">
                    Cancel
                </button>
                <form action="{{ route('admin.destroyListing', $listing->id) }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full bg-red-500 text-white rounded-xl py-2.5 text-sm font-medium
                                   hover:bg-red-600 transition-colors">
                        Yes, delete
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach

</div>

@section('scripts')
<script>
    function openDeleteModal(id) {
        const m = document.getElementById(id);
        m.classList.remove('hidden');
        m.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    function closeDeleteModal(id) {
        const m = document.getElementById(id);
        m.classList.add('hidden');
        m.classList.remove('flex');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', e => {
        if (e.key !== 'Escape') return;
        document.querySelectorAll('[id^="del-listing-"]').forEach(m => {
            m.classList.add('hidden');
            m.classList.remove('flex');
        });
        document.body.style.overflow = '';
    });
</script>
@endsection

@endsection
