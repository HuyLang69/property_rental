<?php $__env->startSection('title', 'Admin Bookings — NestAway'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <?php echo $__env->make('admin._nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="bg-white border border-fog rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate">
                <thead class="bg-cream text-xs uppercase tracking-widest text-ink font-semibold">
                    <tr>
                        <th class="px-6 py-4">Guest</th>
                        <th class="px-6 py-4">Listing</th>
                        <th class="px-6 py-4">Dates</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-fog">
                    <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-fog/30 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-ink"><?php echo e($booking->guest->full_name); ?></p>
                        </td>
                        <td class="px-6 py-4">
                            <a href="<?php echo e(route('listings.show', $booking->listing->id)); ?>" class="text-ink font-medium hover:underline truncate inline-block w-40" title="<?php echo e($booking->listing->title); ?>">
                                <?php echo e($booking->listing->title); ?>

                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p><?php echo e($booking->check_in->format('M d')); ?> - <?php echo e($booking->check_out->format('M d, Y')); ?></p>
                            <p class="text-xs text-silver mt-0.5"><?php echo e($booking->nights); ?> nights</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-[10px] uppercase tracking-widest font-semibold px-2.5 py-1 rounded-full
                                <?php echo e($booking->status === 'confirmed' ? 'bg-ink text-white' : ''); ?>

                                <?php echo e($booking->status === 'pending'   ? 'bg-fog text-slate' : ''); ?>

                                <?php echo e($booking->status === 'cancelled' ? 'bg-red-50 text-red-400' : ''); ?>">
                                <?php echo e(ucfirst($booking->status)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-semibold text-ink">
                            $<?php echo e(number_format($booking->total / 100, 2)); ?>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        <?php echo e($bookings->links()); ?>

    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Documents\GitHub\property-rental-laravel\property_rental\resources\views/admin/bookings.blade.php ENDPATH**/ ?>