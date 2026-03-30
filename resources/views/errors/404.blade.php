@extends('layout')

@section('title', '404 — Page Not Found')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4">
    <div class="text-center max-w-md">
        <p class="font-display text-[8rem] font-bold leading-none text-fog select-none">404</p>
        <h1 class="font-display text-3xl font-bold tracking-tight text-ink mt-2 mb-3">Page not found</h1>
        <p class="text-sm text-slate leading-relaxed mb-8">
            The page you're looking for doesn't exist or may have been moved.
        </p>
        <div class="flex items-center justify-center gap-3">
            <a href="{{ url('/') }}"
               class="bg-ink text-white text-sm font-medium rounded-full px-6 py-3 hover:bg-carbon transition-colors">
                Go home
            </a>
            <a href="{{ route('listings.index') }}"
               class="border border-fog text-sm font-medium rounded-full px-6 py-3 hover:border-ink transition-colors">
                Browse listings
            </a>
        </div>
    </div>
</div>
@endsection