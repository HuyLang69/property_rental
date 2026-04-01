<?php $__env->startSection('title', 'Admin Dashboard — NestAway'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <?php echo $__env->make('admin._nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        
        <div class="bg-white border border-fog rounded-2xl p-6">
            <p class="text-sm font-medium text-slate mb-1">Total Users</p>
            <p class="font-display text-4xl font-bold text-ink"><?php echo e(number_format($stats['users'])); ?></p>
        </div>

        
        <div class="bg-white border border-fog rounded-2xl p-6">
            <p class="text-sm font-medium text-slate mb-1">Total Listings</p>
            <p class="font-display text-4xl font-bold text-ink"><?php echo e(number_format($stats['listings'])); ?></p>
        </div>

        
        <div class="bg-white border border-fog rounded-2xl p-6">
            <p class="text-sm font-medium text-slate mb-1">Total Bookings</p>
            <p class="font-display text-4xl font-bold text-ink"><?php echo e(number_format($stats['bookings'])); ?></p>
        </div>

        
        <div class="bg-white border text-white bg-ink rounded-2xl p-6">
            <p class="text-sm font-medium text-gray-300 mb-1">Total Revenue</p>
            <p class="font-display text-4xl font-bold">$<?php echo e(number_format($stats['revenue'] / 100, 2)); ?></p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Documents\GitHub\property-rental-laravel\property_rental\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>