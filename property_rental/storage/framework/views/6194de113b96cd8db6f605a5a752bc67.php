<?php $__env->startSection('title', '403 — Forbidden'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-[70vh] flex items-center justify-center px-4">
    <div class="text-center max-w-md">
        <p class="font-display text-[8rem] font-bold leading-none text-fog select-none">403</p>
        <h1 class="font-display text-3xl font-bold tracking-tight text-ink mt-2 mb-3">Access denied</h1>
        <p class="text-sm text-slate leading-relaxed mb-8">
            You don't have permission to view this page.
        </p>
        <div class="flex items-center justify-center gap-3">
            <a href="<?php echo e(url('/')); ?>"
               class="bg-ink text-white text-sm font-medium rounded-full px-6 py-3 hover:bg-carbon transition-colors">
                Go home
            </a>
            <?php if(auth()->guard()->guest()): ?>
            <a href="<?php echo e(route('login')); ?>"
               class="border border-fog text-sm font-medium rounded-full px-6 py-3 hover:border-ink transition-colors">
                Log in
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Documents\GitHub\property-rental-laravel\property_rental\resources\views/errors/403.blade.php ENDPATH**/ ?>