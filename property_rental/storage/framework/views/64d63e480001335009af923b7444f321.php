<?php $__env->startSection('title', 'My Profile — NestAway'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <div class="mb-8">
        <p class="text-xs uppercase tracking-widest text-silver mb-1">Account</p>
        <h1 class="font-display text-3xl font-bold tracking-tight text-ink">My profile</h1>
    </div>

    <?php if(session('success')): ?>
    <div class="flex items-center gap-3 bg-white border border-fog rounded-2xl px-4 py-3 mb-6">
        <svg class="w-4 h-4 text-ink shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        <p class="text-sm text-ink"><?php echo e(session('success')); ?></p>
    </div>
    <?php endif; ?>

    
    <form action="<?php echo e(route('profile.update')); ?>" method="POST" class="flex flex-col gap-6 mb-10">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="bg-white border border-fog rounded-2xl p-6 flex flex-col gap-5">
            <h2 class="text-sm font-semibold text-ink uppercase tracking-widest">Personal info</h2>

            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-slate uppercase tracking-widest">First name</label>
                    <input autocomplete="off" type="text" name="first_name"
                           value="<?php echo e(old('first_name', $user->first_name)); ?>"
                           class="border border-fog rounded-xl px-4 py-3 text-sm text-ink bg-cream focus:border-ink focus:outline-none transition-colors" />
                    <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-slate uppercase tracking-widest">Last name</label>
                    <input autocomplete="off" type="text" name="last_name"
                           value="<?php echo e(old('last_name', $user->last_name)); ?>"
                           class="border border-fog rounded-xl px-4 py-3 text-sm text-ink bg-cream focus:border-ink focus:outline-none transition-colors" />
                    <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-slate uppercase tracking-widest">Email</label>
                <input autocomplete="off" type="email" name="email"
                       value="<?php echo e(old('email', $user->email)); ?>"
                       class="border border-fog rounded-xl px-4 py-3 text-sm text-ink bg-cream focus:border-ink focus:outline-none transition-colors" />
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-slate uppercase tracking-widest">Phone <span class="normal-case text-silver">(optional)</span></label>
                <input autocomplete="off" type="text" name="phone"
                       value="<?php echo e(old('phone', $user->phone)); ?>"
                       placeholder="+351 912 345 678"
                       class="border border-fog rounded-xl px-4 py-3 text-sm text-ink placeholder-silver bg-cream focus:border-ink focus:outline-none transition-colors" />
                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-slate uppercase tracking-widest">Bio <span class="normal-case text-silver">(optional)</span></label>
                <textarea autocomplete="off" name="bio" rows="3"
                          placeholder="Tell hosts a little about yourself…"
                          class="border border-fog rounded-xl px-4 py-3 text-sm text-ink placeholder-silver bg-cream focus:border-ink focus:outline-none transition-colors resize-none"><?php echo e(old('bio', $user->bio)); ?></textarea>
                <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-ink text-white text-sm font-medium rounded-full px-8 py-3 hover:bg-carbon transition-colors">
                Save changes
            </button>
        </div>
    </form>

    
    <form action="<?php echo e(route('profile.password')); ?>" method="POST" class="flex flex-col gap-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="bg-white border border-fog rounded-2xl p-6 flex flex-col gap-5">
            <h2 class="text-sm font-semibold text-ink uppercase tracking-widest">Change password</h2>

            <?php if(session('password_success')): ?>
            <div class="flex items-center gap-3 bg-white border border-fog rounded-xl px-4 py-3">
                <svg class="w-4 h-4 text-ink shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <p class="text-sm text-ink"><?php echo e(session('password_success')); ?></p>
            </div>
            <?php endif; ?>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-slate uppercase tracking-widest">Current password</label>
                <input autocomplete="off" type="password" name="current_password"
                       class="border border-fog rounded-xl px-4 py-3 text-sm text-ink bg-cream focus:border-ink focus:outline-none transition-colors" />
                <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-slate uppercase tracking-widest">New password</label>
                <input autocomplete="off" type="password" name="password"
                       class="border border-fog rounded-xl px-4 py-3 text-sm text-ink bg-cream focus:border-ink focus:outline-none transition-colors" />
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-slate uppercase tracking-widest">Confirm new password</label>
                <input autocomplete="off" type="password" name="password_confirmation"
                       class="border border-fog rounded-xl px-4 py-3 text-sm text-ink bg-cream focus:border-ink focus:outline-none transition-colors" />
            </div>

            <p class="text-xs text-silver">Min. 8 characters, must include uppercase, lowercase and a number.</p>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-ink text-white text-sm font-medium rounded-full px-8 py-3 hover:bg-carbon transition-colors">
                Update password
            </button>
        </div>
    </form>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Documents\GitHub\property-rental-laravel\property_rental\resources\views/profile/edit.blade.php ENDPATH**/ ?>