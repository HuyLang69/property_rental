<?php $__env->startSection('title', 'Reviews — NestAway'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <?php echo $__env->make('host._nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <?php if($reviews->count() > 0): ?>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10">
        <div class="bg-ink text-white rounded-2xl p-6">
            <p class="text-xs uppercase tracking-widest text-white/50 mb-2">Average rating</p>
            <div class="flex items-baseline gap-2">
                <p class="font-display text-4xl font-bold"><?php echo e(number_format($avgRating, 1)); ?></p>
                <svg class="w-5 h-5 text-white/70 mb-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
            <p class="text-xs text-white/50 mt-1">out of 5</p>
        </div>
        <div class="bg-white border border-fog rounded-2xl p-6">
            <p class="text-xs uppercase tracking-widest text-silver mb-2">Total reviews</p>
            <p class="font-display text-4xl font-bold text-ink"><?php echo e($reviews->count()); ?></p>
        </div>
        <div class="bg-white border border-fog rounded-2xl p-6">
            <p class="text-xs uppercase tracking-widest text-silver mb-2">5-star reviews</p>
            <p class="font-display text-4xl font-bold text-ink"><?php echo e($reviews->where('rating', 5)->count()); ?></p>
            <p class="text-xs text-silver mt-1"><?php echo e($reviews->count() > 0 ? round($reviews->where('rating', 5)->count() / $reviews->count() * 100) : 0); ?>% of total</p>
        </div>
    </div>
    <?php endif; ?>

    <?php if($reviews->isEmpty()): ?>
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <svg class="w-12 h-12 text-fog mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
            </svg>
            <p class="font-semibold text-ink mb-1">No reviews yet</p>
            <p class="text-sm text-silver">Reviews from guests will appear here after their stay.</p>
        </div>
    <?php else: ?>
        <div class="flex flex-col gap-4">
            <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white border border-fog rounded-2xl p-5 flex flex-col gap-4">

                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-full bg-fog flex items-center justify-center text-xs font-semibold text-ink shrink-0">
                            <?php echo e(strtoupper(substr($review->user->first_name, 0, 1))); ?><?php echo e(strtoupper(substr($review->user->last_name, 0, 1))); ?>

                        </div>
                        <div>
                            <p class="text-sm font-semibold text-ink">
                                <?php echo e($review->user->first_name); ?> <?php echo e(substr($review->user->last_name, 0, 1)); ?>.
                            </p>
                            <p class="text-xs text-silver mt-0.5"><?php echo e($review->created_at->format('M d, Y')); ?></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-1 shrink-0">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                        <svg class="w-3.5 h-3.5 <?php echo e($i <= $review->rating ? 'text-ink' : 'text-fog'); ?>"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <?php endfor; ?>
                    </div>
                </div>

                <p class="text-sm text-slate leading-relaxed"><?php echo e($review->comment); ?></p>

                <div class="flex items-center gap-2 pt-1 border-t border-fog">
                    <svg class="w-3.5 h-3.5 text-silver" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 012.092 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75"/>
                    </svg>
                    <a href="<?php echo e(route('listings.show', $review->listing_id)); ?>"
                       class="text-xs text-silver hover:text-ink transition-colors truncate">
                        <?php echo e($review->listing->title); ?>

                    </a>
                </div>

            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Documents\GitHub\property-rental-laravel\property_rental\resources\views/host/reviews.blade.php ENDPATH**/ ?>