<?php $__env->startSection('title', 'My Trips — NestAway'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <?php echo $__env->make('dashboard._nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php if(session('success')): ?>
    <div class="flex items-center gap-3 bg-white border border-fog rounded-2xl px-4 py-3 mb-6">
        <svg class="w-4 h-4 text-ink shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        <p class="text-sm text-ink"><?php echo e(session('success')); ?></p>
    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="flex items-center gap-3 bg-red-50 border border-red-100 rounded-2xl px-4 py-3 mb-6">
        <p class="text-sm text-red-500"><?php echo e(session('error')); ?></p>
    </div>
    <?php endif; ?>

    
    <?php
        $now = now();
    ?>

    <div class="flex gap-1 mb-6 border-b border-fog overflow-x-auto">
        <?php $__currentLoopData = [
            'upcoming'  => 'Upcoming ('  . $counts['upcoming']  . ')',
            'past'      => 'Past ('      . $counts['past']      . ')',
            'cancelled' => 'Cancelled (' . $counts['cancelled'] . ')',
            'all'       => 'All ('       . $counts['all']       . ')',
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('dashboard.bookings', ['filter' => $key])); ?>"
           class="whitespace-nowrap px-4 py-2.5 text-sm font-medium transition-colors border-b-2 -mb-px
                  <?php echo e($filter === $key ? 'border-ink text-ink' : 'border-transparent text-silver hover:text-ink'); ?>">
            <?php echo e($label); ?>

        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if($bookings->isEmpty()): ?>
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <svg class="w-12 h-12 text-fog mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/>
            </svg>
            <?php if($filter === 'upcoming'): ?>
                <p class="font-semibold text-ink mb-1">No upcoming trips</p>
                <p class="text-sm text-silver mb-6">Time to plan your next stay.</p>
                <a href="<?php echo e(route('listings.index')); ?>"
                   class="bg-ink text-white text-sm font-medium rounded-full px-6 py-3 hover:bg-carbon transition-colors">
                    Browse listings
                </a>
            <?php elseif($filter === 'past'): ?>
                <p class="font-semibold text-ink mb-1">No past trips yet</p>
                <p class="text-sm text-silver">Your completed stays will appear here.</p>
            <?php elseif($filter === 'cancelled'): ?>
                <p class="font-semibold text-ink mb-1">No cancelled bookings</p>
                <p class="text-sm text-silver">You haven't cancelled anything.</p>
            <?php else: ?>
                <p class="font-semibold text-ink mb-1">No trips yet</p>
                <p class="text-sm text-silver mb-6">Time to find somewhere to stay.</p>
                <a href="<?php echo e(route('listings.index')); ?>"
                   class="bg-ink text-white text-sm font-medium rounded-full px-6 py-3 hover:bg-carbon transition-colors">
                    Browse listings
                </a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="flex flex-col gap-4">
            <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white border border-fog rounded-2xl overflow-hidden flex flex-col sm:flex-row">

                <div class="w-full sm:w-44 h-40 sm:h-auto shrink-0 bg-fog overflow-hidden">
                    <?php if($booking->listing->coverImage): ?>
                        <img src="<?php echo e($booking->listing->coverImage->path); ?>"
                             alt="<?php echo e($booking->listing->title); ?>"
                             class="w-full h-full object-cover" />
                    <?php else: ?>
                        <div class="w-full h-full bg-fog"></div>
                    <?php endif; ?>
                </div>

                <div class="flex flex-1 flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-5">
                    <div class="flex-1 min-w-0">
                        <div class="mb-2">
                            <span class="text-[10px] uppercase tracking-widest font-semibold px-2.5 py-1 rounded-full
                                <?php echo e($booking->status === 'confirmed' ? 'bg-ink text-white' : ''); ?>

                                <?php echo e($booking->status === 'pending'   ? 'bg-fog text-slate' : ''); ?>

                                <?php echo e($booking->status === 'cancelled' ? 'bg-red-50 text-red-400' : ''); ?>">
                                <?php echo e(ucfirst($booking->status)); ?>

                            </span>
                        </div>
                        <h3 class="font-semibold text-ink leading-snug"><?php echo e($booking->listing->title); ?></h3>
                        <p class="text-xs text-silver mt-0.5"><?php echo e($booking->listing->city); ?>, <?php echo e($booking->listing->country); ?></p>
                        <p class="text-xs text-slate mt-2 flex flex-wrap gap-x-2">
                            <span><?php echo e($booking->check_in->format('M d, Y')); ?> → <?php echo e($booking->check_out->format('M d, Y')); ?></span>
                            <span>· <?php echo e($booking->nights); ?> <?php echo e(Str::plural('night', $booking->nights)); ?></span>
                            <span>· <?php echo e($booking->guests); ?> <?php echo e(Str::plural('guest', $booking->guests)); ?></span>
                        </p>
                    </div>

                    <div class="flex flex-col items-start sm:items-end gap-3 shrink-0">
                        <p class="text-sm font-bold text-ink">$<?php echo e(number_format($booking->total / 100, 2)); ?></p>
                        <div class="flex flex-wrap gap-2">
                            <a href="<?php echo e(route('bookings.show', $booking->id)); ?>"
                               class="text-xs font-medium border border-fog rounded-full px-3 py-1.5 hover:border-ink transition-colors">
                                View
                            </a>

                            
                            <?php if($booking->status === 'confirmed' && $booking->check_out->isPast() && !$booking->hasReview()): ?>
                            <a href="<?php echo e(route('reviews.create', $booking->id)); ?>"
                               class="text-xs font-medium border border-fog rounded-full px-3 py-1.5 hover:border-ink transition-colors">
                                Leave review
                            </a>
                            <?php elseif($booking->hasReview()): ?>
                            <span class="text-xs text-silver flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                Reviewed
                            </span>
                            <?php endif; ?>

                            <?php if($booking->status !== 'cancelled'): ?>
                            <button type="button"
                                    onclick="openModal('modal-<?php echo e($booking->id); ?>')"
                                    class="text-xs font-medium border border-fog rounded-full px-3 py-1.5 text-slate hover:border-red-300 hover:text-red-400 transition-colors">
                                Cancel
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>

            
            <?php if($booking->status !== 'cancelled'): ?>
            <div id="modal-<?php echo e($booking->id); ?>" class="fixed inset-0 z-50 hidden items-center justify-center px-4">
                <div class="absolute inset-0 bg-ink/40 backdrop-blur-sm"
                     onclick="closeModal('modal-<?php echo e($booking->id); ?>')"></div>
                <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 flex flex-col gap-5">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-ink">Cancel this booking?</h3>
                            <p class="text-sm text-slate mt-1 leading-relaxed">
                                <?php echo e($booking->listing->title); ?><br>
                                <?php echo e($booking->check_in->format('M d')); ?> – <?php echo e($booking->check_out->format('M d, Y')); ?>

                            </p>
                            <p class="text-xs text-silver mt-2">This action cannot be undone.</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="button"
                                onclick="closeModal('modal-<?php echo e($booking->id); ?>')"
                                class="flex-1 border border-fog rounded-xl py-2.5 text-sm font-medium text-slate hover:border-ink hover:text-ink transition-colors">
                            Keep booking
                        </button>
                        <form action="<?php echo e(route('bookings.cancel', $booking->id)); ?>" method="POST" class="flex-1">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit"
                                    class="w-full bg-red-500 text-white rounded-xl py-2.5 text-sm font-medium hover:bg-red-600 transition-colors">
                                Yes, cancel
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-6">
            <?php echo e($bookings->links()); ?>

        </div>
    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    function openModal(id) {
        const m = document.getElementById(id);
        m.classList.remove('hidden');
        m.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        const m = document.getElementById(id);
        m.classList.add('hidden');
        m.classList.remove('flex');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', e => {
        if (e.key !== 'Escape') return;
        document.querySelectorAll('[id^="modal-"]').forEach(m => {
            m.classList.add('hidden');
            m.classList.remove('flex');
        });
        document.body.style.overflow = '';
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Documents\GitHub\property-rental-laravel\property_rental\resources\views/dashboard/bookings.blade.php ENDPATH**/ ?>