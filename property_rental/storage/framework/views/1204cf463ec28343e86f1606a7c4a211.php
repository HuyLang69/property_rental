<?php $__env->startSection('title', 'Admin Users — NestAway'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <?php echo $__env->make('admin._nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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

    <div class="bg-white border border-fog rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate">
                <thead class="bg-cream text-xs uppercase tracking-widest text-ink font-semibold">
                    <tr>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Joined</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-fog">
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-fog/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-fog flex items-center justify-center text-xs font-semibold text-ink shrink-0 overflow-hidden">
                                    <?php if($user->avatar): ?>
                                        <img src="<?php echo e(asset('storage/' . $user->avatar)); ?>" alt="" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <?php echo e(strtoupper(substr($user->first_name, 0, 1))); ?><?php echo e(strtoupper(substr($user->last_name, 0, 1))); ?>

                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="font-semibold text-ink"><?php echo e($user->full_name); ?></p>
                                    <p class="text-xs text-silver"><?php echo e($user->email); ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($user->created_at->format('M d, Y')); ?></td>
                        <td class="px-6 py-4">
                            <?php if($user->is_admin): ?>
                                <span class="bg-ink text-white text-[10px] uppercase tracking-widest font-semibold px-2.5 py-1 rounded-full">Admin</span>
                            <?php else: ?>
                                <span class="bg-fog text-slate text-[10px] uppercase tracking-widest font-semibold px-2.5 py-1 rounded-full">User</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <?php if(auth()->id() !== $user->id): ?>
                            <button type="button"
                                    onclick="openDeleteModal('del-user-<?php echo e($user->id); ?>')"
                                    class="text-xs font-medium border border-fog rounded-full px-3 py-1.5 text-slate hover:border-red-300 hover:text-red-400 transition-colors">
                                Delete
                            </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        <?php echo e($users->links()); ?>

    </div>

    
    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(auth()->id() !== $user->id): ?>
    <div id="del-user-<?php echo e($user->id); ?>" class="fixed inset-0 z-50 hidden items-center justify-center px-4">
        <div class="absolute inset-0 bg-ink/40 backdrop-blur-sm"
             onclick="closeDeleteModal('del-user-<?php echo e($user->id); ?>')">
        </div>
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 flex flex-col gap-5">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-ink">Delete this user?</h3>
                    <p class="text-sm text-slate mt-1 leading-relaxed"><?php echo e($user->full_name); ?></p>
                    <p class="text-xs text-silver mt-2">All associated data will be removed. This cannot be undone.</p>
                </div>
            </div>
            <div class="flex gap-3">
                <button type="button"
                        onclick="closeDeleteModal('del-user-<?php echo e($user->id); ?>')" 
                        class="flex-1 border border-fog rounded-xl py-2.5 text-sm font-medium text-slate
                               hover:border-ink hover:text-ink transition-colors">
                    Cancel
                </button>
                <form action="<?php echo e(route('admin.destroyUser', $user->id)); ?>" method="POST" class="flex-1">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit"
                            class="w-full bg-red-500 text-white rounded-xl py-2.5 text-sm font-medium
                                   hover:bg-red-600 transition-colors">
                        Yes, delete
                    </button>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>

<?php $__env->startSection('scripts'); ?>
<script>
    function openDeleteModal(id) {
        const m = document.getElementById(id);
        m.classList.remove('hidden');
        m.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    function closeDeleteModal(id) {
        const m = document.getElementById(id);
        m.classList.add('hidden');
        m.classList.remove('flex');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', e => {
        if (e.key !== 'Escape') return;
        document.querySelectorAll('[id^="del-user-"]').forEach(m => {
            m.classList.add('hidden');
            m.classList.remove('flex');
        });
        document.body.style.overflow = '';
    });
</script>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Documents\GitHub\property-rental-laravel\property_rental\resources\views/admin/users.blade.php ENDPATH**/ ?>