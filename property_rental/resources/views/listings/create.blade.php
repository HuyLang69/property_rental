@extends('layout')

@section('title', 'List Your Property — NestAway')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Header --}}
    <div class="mb-10 fade-up">
        <p class="text-xs uppercase tracking-widest text-silver mb-1">Host</p>
        <h1 class="font-display text-4xl font-bold tracking-tight text-ink">List your property</h1>
        <p class="mt-2 text-sm text-slate">Fill in the details below. You can always edit later.</p>
    </div>

    @if ($errors->any())
    <div class="bg-red-50 border border-red-100 rounded-2xl px-5 py-4 mb-8 fade-up d1">
        <p class="text-sm font-semibold text-red-500 mb-2">Please fix the following errors:</p>
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li class="text-sm text-red-400">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('listings.store') }}" method="POST"
          enctype="multipart/form-data" autocomplete="off"
          class="flex flex-col gap-8">
        @csrf

        {{-- 1. Basic info --}}
        <div class="bg-white border border-fog rounded-2xl p-6 fade-up d1">
            <h2 class="text-sm font-semibold text-ink uppercase tracking-widest mb-5">Basic info</h2>

            <div class="flex flex-col gap-5">
                {{-- Title --}}
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="title">Title</label>
                    <input type="text" id="title" name="title"
                           value="{{ old('title') }}"
                           placeholder="e.g. Bright studio in central Lisbon"
                           autocomplete="off"
                           class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink placeholder-silver
                                  focus:border-ink focus:outline-none transition-colors
                                  {{ $errors->has('title') ? 'border-red-300' : '' }}" />
                    @error('title')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Type --}}
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="type">Property type</label>
                    <select id="type" name="type"
                            class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink bg-white
                                   focus:border-ink focus:outline-none transition-colors
                                   {{ $errors->has('type') ? 'border-red-300' : '' }}">
                        <option value="">Select type…</option>
                        @foreach (['apartment', 'house', 'studio', 'villa', 'room'] as $t)
                            <option value="{{ $t }}" {{ old('type') === $t ? 'selected' : '' }}>
                                {{ ucfirst($t) }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="description">Description</label>
                    <textarea id="description" name="description" rows="5"
                              placeholder="Describe your space, the neighbourhood, what makes it special…"
                              autocomplete="off"
                              class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink placeholder-silver
                                     focus:border-ink focus:outline-none transition-colors resize-none
                                     {{ $errors->has('description') ? 'border-red-300' : '' }}">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- 2. Location --}}
        <div class="bg-white border border-fog rounded-2xl p-6 fade-up d2">
            <h2 class="text-sm font-semibold text-ink uppercase tracking-widest mb-5">Location</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="city">City</label>
                    <input type="text" id="city" name="city"
                           value="{{ old('city') }}"
                           placeholder="Lisbon"
                           autocomplete="off"
                           class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink placeholder-silver
                                  focus:border-ink focus:outline-none transition-colors
                                  {{ $errors->has('city') ? 'border-red-300' : '' }}" />
                    @error('city')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="country">Country</label>
                    <input type="text" id="country" name="country"
                           value="{{ old('country') }}"
                           placeholder="Portugal"
                           autocomplete="off"
                           class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink placeholder-silver
                                  focus:border-ink focus:outline-none transition-colors
                                  {{ $errors->has('country') ? 'border-red-300' : '' }}" />
                    @error('country')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-ink mb-1.5" for="address">Address</label>
                    <input type="text" id="address" name="address"
                           value="{{ old('address') }}"
                           placeholder="Rua Augusta, 28"
                           autocomplete="off"
                           class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink placeholder-silver
                                  focus:border-ink focus:outline-none transition-colors
                                  {{ $errors->has('address') ? 'border-red-300' : '' }}" />
                    @error('address')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- 3. Details --}}
        <div class="bg-white border border-fog rounded-2xl p-6 fade-up d3">
            <h2 class="text-sm font-semibold text-ink uppercase tracking-widest mb-5">Details</h2>

            <div class="grid grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="bedrooms">Bedrooms</label>
                    <input type="number" id="bedrooms" name="bedrooms"
                           value="{{ old('bedrooms', 1) }}"
                           min="0" max="50"
                           autocomplete="off"
                           class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink
                                  focus:border-ink focus:outline-none transition-colors
                                  {{ $errors->has('bedrooms') ? 'border-red-300' : '' }}" />
                    @error('bedrooms')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="bathrooms">Bathrooms</label>
                    <input type="number" id="bathrooms" name="bathrooms"
                           value="{{ old('bathrooms', 1) }}"
                           min="0" max="50"
                           autocomplete="off"
                           class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink
                                  focus:border-ink focus:outline-none transition-colors
                                  {{ $errors->has('bathrooms') ? 'border-red-300' : '' }}" />
                    @error('bathrooms')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="max_guests">Max guests</label>
                    <input type="number" id="max_guests" name="max_guests"
                           value="{{ old('max_guests', 2) }}"
                           min="1" max="50"
                           autocomplete="off"
                           class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink
                                  focus:border-ink focus:outline-none transition-colors
                                  {{ $errors->has('max_guests') ? 'border-red-300' : '' }}" />
                    @error('max_guests')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- 4. Pricing --}}
        <div class="bg-white border border-fog rounded-2xl p-6 fade-up d3">
            <h2 class="text-sm font-semibold text-ink uppercase tracking-widest mb-5">Pricing</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="price_per_night">Price per night (€)</label>
                    <input type="number" id="price_per_night" name="price_per_night"
                           value="{{ old('price_per_night') }}"
                           min="1" max="99999" step="0.01"
                           placeholder="85.00"
                           autocomplete="off"
                           class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink placeholder-silver
                                  focus:border-ink focus:outline-none transition-colors
                                  {{ $errors->has('price_per_night') ? 'border-red-300' : '' }}" />
                    @error('price_per_night')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="cleaning_fee">
                        Cleaning fee (€) <span class="text-silver font-normal">optional</span>
                    </label>
                    <input type="number" id="cleaning_fee" name="cleaning_fee"
                           value="{{ old('cleaning_fee') }}"
                           min="0" max="9999" step="0.01"
                           placeholder="0.00"
                           autocomplete="off"
                           class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink placeholder-silver
                                  focus:border-ink focus:outline-none transition-colors" />
                </div>
            </div>
        </div>

        {{-- 5. Photos --}}
        <div class="bg-white border border-fog rounded-2xl p-6 fade-up d4">
            <h2 class="text-sm font-semibold text-ink uppercase tracking-widest mb-1">Photos</h2>
            <p class="text-xs text-silver mb-5">Add 1–10 photos. First photo will be the cover. JPG, PNG or WebP, max 4 MB each.</p>

            <label for="images"
                   class="flex flex-col items-center justify-center gap-3 border-2 border-dashed border-fog
                          rounded-xl py-10 px-4 cursor-pointer hover:border-silver transition-colors
                          {{ $errors->has('images') || $errors->has('images.*') ? 'border-red-300' : '' }}">
                <svg class="w-8 h-8 text-silver" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 3h18M3 21h18M13.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                </svg>
                <span class="text-sm text-slate">Click to choose photos</span>
                <span id="file-count" class="text-xs text-silver"></span>
                <input id="images" type="file" name="images[]"
                       multiple accept="image/jpeg,image/png,image/webp"
                       autocomplete="off"
                       class="sr-only"
                       onchange="previewImages(this)" />
            </label>

            @error('images')
                <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
            @enderror
            @error('images.*')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror

            {{-- Preview grid --}}
            <div id="preview-grid" class="grid grid-cols-3 sm:grid-cols-5 gap-2 mt-4"></div>
        </div>

        {{-- 6. Availability --}}
        <div class="bg-white border border-fog rounded-2xl p-6 fade-up d4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-ink">Available for booking</p>
                    <p class="text-xs text-silver mt-0.5">Uncheck to hide this listing while you prepare it.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="is_available" value="0" />
                    <input type="checkbox" id="is_available" name="is_available" value="1"
                           {{ old('is_available', '1') == '1' ? 'checked' : '' }}
                           class="sr-only peer" />
                    <div class="w-11 h-6 bg-fog rounded-full peer peer-checked:bg-ink transition-colors"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                </label>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex items-center justify-between fade-up d5">
            <a href="{{ route('host.bookings') }}"
               class="text-sm text-silver hover:text-ink transition-colors">
                Cancel
            </a>
            <button type="submit"
                    class="bg-ink text-white text-sm font-medium rounded-full px-8 py-3
                           hover:bg-carbon transition-colors">
                Publish listing
            </button>
        </div>

    </form>
</div>
@endsection

@section('scripts')
<script>
    function previewImages(input) {
        const grid = document.getElementById('preview-grid');
        const count = document.getElementById('file-count');
        grid.innerHTML = '';

        const files = Array.from(input.files);
        count.textContent = files.length === 0
            ? ''
            : `${files.length} photo${files.length > 1 ? 's' : ''} selected`;

        files.forEach((file, i) => {
            const reader = new FileReader();
            reader.onload = e => {
                const wrap = document.createElement('div');
                wrap.className = 'relative aspect-square rounded-xl overflow-hidden bg-fog';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-full object-cover';

                if (i === 0) {
                    const badge = document.createElement('div');
                    badge.textContent = 'Cover';
                    badge.className = 'absolute bottom-1 left-1 text-[10px] font-semibold bg-ink text-white rounded-full px-2 py-0.5';
                    wrap.appendChild(badge);
                }
                wrap.appendChild(img);
                grid.appendChild(wrap);
            };
            reader.readAsDataURL(file);
        });
    }
</script>
@endsection
