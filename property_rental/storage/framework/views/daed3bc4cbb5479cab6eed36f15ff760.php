<?php if($paginator->hasPages()): ?>
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between mt-8">
        
        <div class="flex justify-between flex-1 sm:hidden gap-2">
            <?php if($paginator->onFirstPage()): ?>
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-silver bg-cream border border-fog cursor-not-allowed rounded-full">
                    Previous
                </span>
            <?php else: ?>
                <a href="<?php echo e($paginator->previousPageUrl()); ?>" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-slate bg-white border border-fog hover:text-ink hover:border-silver transition-colors rounded-full">
                    Previous
                </a>
            <?php endif; ?>

            <?php if($paginator->hasMorePages()): ?>
                <a href="<?php echo e($paginator->nextPageUrl()); ?>" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-slate bg-white border border-fog hover:text-ink hover:border-silver transition-colors rounded-full">
                    Next
                </a>
            <?php else: ?>
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-silver bg-cream border border-fog cursor-not-allowed rounded-full">
                    Next
                </span>
            <?php endif; ?>
        </div>

        
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-slate">
                    Showing
                    <span class="font-semibold text-ink"><?php echo e($paginator->firstItem()); ?></span>
                    to
                    <span class="font-semibold text-ink"><?php echo e($paginator->lastItem()); ?></span>
                    of
                    <span class="font-semibold text-ink"><?php echo e($paginator->total()); ?></span>
                    results
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-full gap-1">
                    
                    <?php if($paginator->onFirstPage()): ?>
                        <span aria-disabled="true" aria-label="Previous">
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-silver bg-cream border border-transparent cursor-not-allowed rounded-full h-10 w-10 justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    <?php else: ?>
                        <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-slate bg-white border border-fog hover:text-ink hover:border-silver transition-colors rounded-full h-10 w-10 justify-center" aria-label="Previous">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    <?php endif; ?>

                    
                    <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                        <?php if(is_string($element)): ?>
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-silver bg-transparent border border-transparent cursor-default rounded-full h-10 w-10 justify-center"><?php echo e($element); ?></span>
                            </span>
                        <?php endif; ?>

                        
                        <?php if(is_array($element)): ?>
                            <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($page == $paginator->currentPage()): ?>
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-ink border border-ink cursor-default rounded-full h-10 w-10 justify-center"><?php echo e($page); ?></span>
                                    </span>
                                <?php else: ?>
                                    <a href="<?php echo e($url); ?>" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-slate bg-white border border-fog hover:text-ink hover:border-ink transition-colors rounded-full h-10 w-10 justify-center" aria-label="Go to page <?php echo e($page); ?>">
                                        <?php echo e($page); ?>

                                    </a>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <?php if($paginator->hasMorePages()): ?>
                        <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-slate bg-white border border-fog hover:text-ink hover:border-silver transition-colors rounded-full h-10 w-10 justify-center" aria-label="Next">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    <?php else: ?>
                        <span aria-disabled="true" aria-label="Next">
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-silver bg-cream border border-transparent cursor-not-allowed rounded-full h-10 w-10 justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </nav>
<?php endif; ?>
<?php /**PATH C:\Users\User\Documents\GitHub\property-rental-laravel\property_rental\resources\views/vendor/pagination/tailwind.blade.php ENDPATH**/ ?>