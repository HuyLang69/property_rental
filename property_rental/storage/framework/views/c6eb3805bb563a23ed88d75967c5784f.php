<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Log in — NestAway</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet" />

    <style>
        body { font-family: 'Jost', sans-serif; }
        .font-display { font-family: 'Cormorant Garamond', serif; }
        input:focus { outline: none; }
    </style>
</head>

<body class="min-h-screen bg-[#f6f4f0] flex items-center justify-center px-4">

    <div class="w-full max-w-md">

        
        <a href="<?php echo e(url('/')); ?>" class="flex items-baseline gap-0.5 justify-center mb-8">
            <span class="font-display text-3xl font-bold tracking-tight text-[#111]">NestAway</span>
            <span class="w-1.5 h-1.5 rounded-full bg-[#111] mb-0.5 inline-block"></span>
        </a>

        <div class="bg-white rounded-2xl border border-[#e4e2de] p-8 shadow-sm">

            <h1 class="font-display text-2xl font-bold text-[#111] mb-1">Welcome back</h1>
            <p class="text-sm text-[#a8a8a8] mb-7">Log in to your account to continue.</p>

            
            <form action="<?php echo e(route('login')); ?>" method="POST" class="flex flex-col gap-5">
                <?php echo csrf_field(); ?>

                
                <div class="flex flex-col gap-1.5">
                    <label for="email" class="text-xs font-medium text-[#5c5c5c] uppercase tracking-widest">Email</label>
                    <input autocomplete="off"
                        id="email" type="email" name="email" required
                        placeholder="you@example.com"
                        value="<?php echo e(old('email')); ?>"
                        class="w-full border border-[#e4e2de] rounded-xl px-4 py-3 text-sm text-[#111] placeholder-[#c0beba] bg-[#f6f4f0] focus:border-[#111] transition-colors"
                    />
                    
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="flex flex-col gap-1.5">
                    <div class="flex items-center justify-between">
                        <label for="password" class="text-xs font-medium text-[#5c5c5c] uppercase tracking-widest">Password</label>
                        <a href="<?php echo e(url('/forgot-password')); ?>" tabindex="-1" class="text-xs text-[#a8a8a8] hover:text-[#111] transition-colors">Forgot password?</a>
                    </div>
                    <input autocomplete="off"
                        id="password" type="password" name="password" required
                        placeholder="••••••••"
                        class="w-full border border-[#e4e2de] rounded-xl px-4 py-3 text-sm text-[#111] placeholder-[#c0beba] bg-[#f6f4f0] focus:border-[#111] transition-colors"
                    />
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                    <input autocomplete="off" type="checkbox" name="remember" class="w-4 h-4 rounded border-[#e4e2de] accent-[#111] cursor-pointer" />
                    <span class="text-sm text-[#5c5c5c]">Remember me</span>
                </label>

                <button type="submit"
                        class="w-full bg-[#111] text-white font-medium text-sm rounded-xl py-3 hover:bg-[#2a2a2a] transition-colors mt-1">
                    Log in
                </button>
            </form>

        </div>

        <p class="text-center text-sm text-[#a8a8a8] mt-6">
            Don't have an account?
            <a href="<?php echo e(route('register')); ?>" class="text-[#111] font-medium hover:underline">Sign up</a>
        </p>

    </div>

</body>
</html><?php /**PATH C:\Users\User\Documents\GitHub\property-rental-laravel\property_rental\resources\views/login.blade.php ENDPATH**/ ?>