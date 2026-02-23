<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign up — NestAway</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet" />

    <style>
        body { font-family: 'Jost', sans-serif; }
        .font-display { font-family: 'Cormorant Garamond', serif; }
        input:focus { outline: none; }
    </style>
</head>

<body class="min-h-screen bg-[#f6f4f0] flex items-center justify-center px-4 py-12">

    <div class="w-full max-w-md">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="flex items-baseline gap-0.5 justify-center mb-8">
            <span class="font-display text-3xl font-bold tracking-tight text-[#111]">NestAway</span>
            <span class="w-1.5 h-1.5 rounded-full bg-[#111] mb-0.5 inline-block"></span>
        </a>

        <div class="bg-white rounded-2xl border border-[#e4e2de] p-8 shadow-sm">

            <h1 class="font-display text-2xl font-bold text-[#111] mb-1">Create an account</h1>
            <p class="text-sm text-[#a8a8a8] mb-7">One account to rent and host — do both, anytime.</p>

            {{-- DYNAMIC: form action points to your register route, add @csrf --}}
            <form action="{{ url('/register') }}" method="POST" class="flex flex-col gap-5">
                @csrf

                {{-- Name row --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label for="first_name" class="text-xs font-medium text-[#5c5c5c] uppercase tracking-widest">First name</label>
                        <input autocomplete="off"
                            id="first_name" type="text" name="first_name" required
                            placeholder="Jane"
                            value="{{ old('first_name') }}"
                            class="w-full border border-[#e4e2de] rounded-xl px-4 py-3 text-sm text-[#111] placeholder-[#c0beba] bg-[#f6f4f0] focus:border-[#111] transition-colors"
                        />
                        @error('first_name')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label for="last_name" class="text-xs font-medium text-[#5c5c5c] uppercase tracking-widest">Last name</label>
                        <input autocomplete="off"
                            id="last_name" type="text" name="last_name" required
                            placeholder="Doe"
                            value="{{ old('last_name') }}"
                            class="w-full border border-[#e4e2de] rounded-xl px-4 py-3 text-sm text-[#111] placeholder-[#c0beba] bg-[#f6f4f0] focus:border-[#111] transition-colors"
                        />
                        @error('last_name')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div class="flex flex-col gap-1.5">
                    <label for="email" class="text-xs font-medium text-[#5c5c5c] uppercase tracking-widest">Email</label>
                    <input autocomplete="off"
                        id="email" type="email" name="email" required
                        placeholder="you@example.com"
                        value="{{ old('email') }}"
                        class="w-full border border-[#e4e2de] rounded-xl px-4 py-3 text-sm text-[#111] placeholder-[#c0beba] bg-[#f6f4f0] focus:border-[#111] transition-colors"
                    />
                    @error('email')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="flex flex-col gap-1.5">
                    <label for="password" class="text-xs font-medium text-[#5c5c5c] uppercase tracking-widest">Password</label>
                    <input autocomplete="off"
                        id="password" type="password" name="password" required
                        placeholder="Min. 8 characters"
                        class="w-full border border-[#e4e2de] rounded-xl px-4 py-3 text-sm text-[#111] placeholder-[#c0beba] bg-[#f6f4f0] focus:border-[#111] transition-colors"
                    />
                    @error('password')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm password --}}
                <div class="flex flex-col gap-1.5">
                    <label for="password_confirmation" class="text-xs font-medium text-[#5c5c5c] uppercase tracking-widest">Confirm password</label>
                    <input autocomplete="off"
                        id="password_confirmation" type="password" name="password_confirmation" required
                        placeholder="••••••••"
                        class="w-full border border-[#e4e2de] rounded-xl px-4 py-3 text-sm text-[#111] placeholder-[#c0beba] bg-[#f6f4f0] focus:border-[#111] transition-colors"
                    />
                </div>

                {{-- Terms --}}
                <label class="flex items-start gap-2.5 cursor-pointer select-none">
                    <input autocomplete="off" type="checkbox" name="terms" required class="w-4 h-4 mt-0.5 rounded border-[#e4e2de] accent-[#111] cursor-pointer shrink-0" />
                    <span class="text-sm text-[#5c5c5c] leading-snug">
                        I agree to the
                        <a href="{{ url('/terms') }}" class="text-[#111] hover:underline">Terms of Service</a>
                        and
                        <a href="{{ url('/privacy') }}" class="text-[#111] hover:underline">Privacy Policy</a>
                    </span>
                </label>

                <button type="submit"
                        class="w-full bg-[#111] text-white font-medium text-sm rounded-xl py-3 hover:bg-[#2a2a2a] transition-colors mt-1">
                    Create account
                </button>
            </form>

        </div>

        <p class="text-center text-sm text-[#a8a8a8] mt-6">
            Already have an account?
            <a href="{{ url('/login') }}" class="text-[#111] font-medium hover:underline">Log in</a>
        </p>

    </div>

</body>
</html>