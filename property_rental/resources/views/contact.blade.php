@extends('layout')

@section('title', 'Contact Us — NestAway')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <h1 class="font-display text-4xl md:text-5xl font-bold tracking-tight text-ink mb-6">Contact Us</h1>
    <div class="prose prose-slate prose-lg max-w-none text-slate leading-relaxed">
        <p class="mb-8">We'd love to hear from you. Whether you have a question about a listing, need help with your account, or just want to share your travel stories.</p>
        
        <div class="bg-white border border-fog rounded-2xl p-8 mb-8">
            <h2 class="font-semibold text-ink text-xl mb-4">Get in touch</h2>
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-silver" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <a href="mailto:hello@nestaway.test" class="text-ink hover:underline font-medium">hello@nestaway.test</a>
                </div>
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-silver" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span class="text-slate">+1 (555) 123-4567</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
