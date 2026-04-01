<?php $__env->startSection('title', 'Earnings — NestAway'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <?php echo $__env->make('host._nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10">
        <div class="bg-ink text-white rounded-2xl p-6">
            <p class="text-xs uppercase tracking-widest text-white/50 mb-2">Total earnings</p>
            <p class="font-display text-4xl font-bold">$<?php echo e(number_format($totalRevenue / 100, 2)); ?></p>
            <p class="text-xs text-white/50 mt-1">from confirmed bookings</p>
        </div>
        <div class="bg-white border border-fog rounded-2xl p-6">
            <p class="text-xs uppercase tracking-widest text-silver mb-2">Confirmed bookings</p>
            <p class="font-display text-4xl font-bold text-ink"><?php echo e($totalBookings); ?></p>
            <p class="text-xs text-silver mt-1">across all listings</p>
        </div>
        <div class="bg-white border border-fog rounded-2xl p-6">
            <p class="text-xs uppercase tracking-widest text-silver mb-2">Active listings</p>
            <p class="font-display text-4xl font-bold text-ink"><?php echo e($listingsWithRevenue->count()); ?></p>
            <p class="text-xs text-silver mt-1">properties listed</p>
        </div>
    </div>

    
    <div class="bg-white border border-fog rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-fog">
            <h2 class="text-sm font-semibold text-ink uppercase tracking-widest">Per-listing breakdown</h2>
        </div>

        <?php if($listingsWithRevenue->isEmpty()): ?>
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <p class="font-semibold text-ink mb-1">No listings yet</p>
                <p class="text-sm text-silver mb-6">Create a listing to start earning.</p>
                <a href="<?php echo e(route('listings.create')); ?>"
                   class="bg-ink text-white text-sm font-medium rounded-full px-6 py-3 hover:bg-carbon transition-colors">
                    Create a listing
                </a>
            </div>
        <?php else: ?>
            <div class="divide-y divide-fog">
                <?php $__currentLoopData = $listingsWithRevenue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center justify-between gap-4 px-6 py-4">
                    <div class="flex items-center gap-4 flex-1 min-w-0">
                        <div class="w-12 h-10 rounded-lg overflow-hidden bg-fog shrink-0">
                            <?php if($listing->coverImage): ?>
                                <img src="<?php echo e($listing->coverImage->path); ?>" class="w-full h-full object-cover" />
                            <?php endif; ?>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-ink truncate"><?php echo e($listing->title); ?></p>
                            <p class="text-xs text-silver mt-0.5">
                                <?php echo e($listing->city); ?> &middot;
                                <?php echo e($listing->booking_count); ?> <?php echo e(Str::plural('booking', $listing->booking_count)); ?>

                            </p>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-sm font-bold text-ink">$<?php echo e(number_format($listing->revenue / 100, 2)); ?></p>
                        <p class="text-xs text-silver mt-0.5">$<?php echo e(number_format($listing->price_per_night / 100, 0)); ?>/night</p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="flex items-center justify-between px-6 py-4 border-t border-fog bg-cream">
                <p class="text-sm font-semibold text-ink">Total</p>
                <p class="text-sm font-bold text-ink">$<?php echo e(number_format($totalRevenue / 100, 2)); ?></p>
            </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Documents\GitHub\property-rental-laravel\property_rental\resources\views/host/earnings.blade.php ENDPATH**/ ?>