<?php $__env->startSection('title', $listing->title . ' — NestAway'); ?>

<?php $__env->startSection('content'); ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    
    <nav class="flex items-center gap-2 text-xs text-silver mb-6">
        <a href="<?php echo e(route('home')); ?>" class="hover:text-ink transition-colors">Home</a>
        <span>/</span>
        <a href="<?php echo e(route('listings.index')); ?>" class="hover:text-ink transition-colors">Listings</a>
        <span>/</span>
        <span class="text-ink truncate max-w-xs"><?php echo e($listing->title); ?></span>
    </nav>

    
    <div class="mb-6">
        <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-ink"><?php echo e($listing->title); ?></h1>
        <div class="flex items-center flex-wrap gap-3 mt-2 text-sm text-slate">
            <?php if($listing->reviews_avg_rating): ?>
            <div class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-ink" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <span class="font-semibold text-ink"><?php echo e(number_format($listing->reviews_avg_rating, 1)); ?></span>
                <span class="text-silver">(<?php echo e($listing->reviews_count); ?> <?php echo e(Str::plural('review', $listing->reviews_count)); ?>)</span>
                <span class="text-fog">·</span>
            </div>
            <?php endif; ?>
            <span><?php echo e($listing->city); ?>, <?php echo e($listing->country); ?></span>
        </div>
    </div>

    
    <?php $images = $listing->images; ?>
    <div class="rounded-2xl overflow-hidden mb-10 bg-fog"
         style="display:grid; grid-template-columns:2fr 1fr 1fr; grid-template-rows:1fr 1fr; gap:4px; height:420px;">

        <div style="grid-row: span 2; overflow:hidden;">
            <?php if($images->count() > 0): ?>
                <img src="<?php echo e($images[0]->path); ?>" alt="<?php echo e($listing->title); ?>" class="w-full h-full object-cover" />
            <?php else: ?>
                <div class="w-full h-full bg-fog flex items-center justify-center">
                    <svg class="w-12 h-12 text-silver" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909"/></svg>
                </div>
            <?php endif; ?>
        </div>

        <?php $__currentLoopData = [1, 2, 3, 4]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div style="overflow:hidden;">
            <?php if($images->count() > $i): ?>
                <img src="<?php echo e($images[$i]->path); ?>" alt="<?php echo e($listing->title); ?>" class="w-full h-full object-cover" loading="lazy" />
            <?php else: ?>
                <div class="w-full h-full bg-fog"></div>
            <?php endif; ?>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

    
    <div class="flex flex-col lg:flex-row gap-12">

        
        <div class="flex-1 min-w-0">

            
            <div class="flex items-center flex-wrap gap-6 pb-8 border-b border-fog">
                <div class="flex flex-col">
                    <span class="text-xs uppercase tracking-widest text-silver">Type</span>
                    <span class="text-sm font-medium text-ink mt-0.5"><?php echo e(ucfirst($listing->type)); ?></span>
                </div>
                <div class="w-px h-8 bg-fog"></div>
                <div class="flex flex-col">
                    <span class="text-xs uppercase tracking-widest text-silver">Bedrooms</span>
                    <span class="text-sm font-medium text-ink mt-0.5"><?php echo e($listing->bedrooms); ?></span>
                </div>
                <div class="w-px h-8 bg-fog"></div>
                <div class="flex flex-col">
                    <span class="text-xs uppercase tracking-widest text-silver">Bathrooms</span>
                    <span class="text-sm font-medium text-ink mt-0.5"><?php echo e($listing->bathrooms); ?></span>
                </div>
                <div class="w-px h-8 bg-fog"></div>
                <div class="flex flex-col">
                    <span class="text-xs uppercase tracking-widest text-silver">Max guests</span>
                    <span class="text-sm font-medium text-ink mt-0.5"><?php echo e($listing->max_guests); ?></span>
                </div>
            </div>

            
            <div class="flex items-center gap-4 py-8 border-b border-fog">
                <div class="w-12 h-12 rounded-full bg-fog flex items-center justify-center shrink-0 overflow-hidden">
                    <?php if($listing->host->avatar): ?>
                        <img src="<?php echo e($listing->host->avatar); ?>" class="w-full h-full object-cover" />
                    <?php else: ?>
                        <svg class="w-6 h-6 text-silver" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/>
                        </svg>
                    <?php endif; ?>
                </div>
                <div>
                    <p class="text-sm font-semibold text-ink">Hosted by <?php echo e($listing->host->full_name); ?></p>
                    <p class="text-xs text-silver mt-0.5">Host since <?php echo e($listing->host->created_at->format('F Y')); ?></p>
                </div>
            </div>

            
            <div class="py-8 border-b border-fog">
                <h2 class="font-display text-xl font-bold text-ink mb-3">About this place</h2>
                <p class="text-sm text-slate leading-relaxed"><?php echo e($listing->description); ?></p>
            </div>

            
            <?php if($listing->reviews->count() > 0): ?>
            <div class="py-8">
                <div class="flex items-center gap-3 mb-6">
                    <svg class="w-5 h-5 text-ink" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <h2 class="font-display text-xl font-bold text-ink">
                        <?php echo e(number_format($listing->reviews_avg_rating, 1)); ?> &middot; <?php echo e($listing->reviews_count); ?> <?php echo e(Str::plural('review', $listing->reviews_count)); ?>

                    </h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <?php $__currentLoopData = $listing->reviews->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-fog flex items-center justify-center text-xs font-semibold text-ink shrink-0">
                                <?php echo e(strtoupper(substr($review->user->first_name, 0, 1))); ?><?php echo e(strtoupper(substr($review->user->last_name, 0, 1))); ?>

                            </div>
                            <div>
                                <p class="text-sm font-semibold text-ink"><?php echo e($review->user->first_name); ?> <?php echo e(substr($review->user->last_name, 0, 1)); ?>.</p>
                                <p class="text-xs text-silver"><?php echo e($review->created_at->format('F Y')); ?></p>
                            </div>
                        </div>
                        <div class="flex gap-0.5 mb-1">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <svg class="w-3 h-3 <?php echo e($i <= $review->rating ? 'text-ink' : 'text-fog'); ?>" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <?php endfor; ?>
                        </div>
                        <p class="text-sm text-slate leading-relaxed"><?php echo e($review->comment); ?></p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

        </div>

        
        <div class="w-full lg:w-80 xl:w-96 shrink-0">
            <div class="sticky top-24 bg-white border border-fog rounded-2xl p-6 shadow-sm">

                <div class="flex items-baseline gap-1 mb-5">
                    <span class="font-display text-3xl font-bold text-ink">$<?php echo e(number_format($listing->price_per_night / 100, 0)); ?></span>
                    <span class="text-sm text-silver">/ night</span>
                </div>

                
                <?php if($errors->any()): ?>
                <div class="mb-4">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p class="text-xs text-red-500 bg-red-50 rounded-xl px-3 py-2 mb-1"><?php echo e($error); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                <?php if(auth()->guard()->check()): ?>
                <form action="<?php echo e(route('bookings.create')); ?>" method="GET" id="booking-form" class="flex flex-col gap-4">
                    <input type="hidden" name="listing_id" value="<?php echo e($listing->id); ?>" />

                    <div id="date-box" class="border border-fog rounded-xl overflow-hidden transition-colors">
                        <div class="grid grid-cols-2 divide-x divide-fog">
                            <div class="px-3 py-2.5">
                                <p class="text-[10px] uppercase tracking-widest text-silver font-medium">Check-in</p>
                                <input
                                    autocomplete="off"
                                    type="date"
                                    name="check_in"
                                    id="check_in"
                                    min="<?php echo e(date('Y-m-d')); ?>"
                                    class="w-full text-sm text-ink bg-transparent focus:outline-none mt-0.5 cursor-pointer"
                                />
                            </div>
                            <div class="px-3 py-2.5">
                                <p class="text-[10px] uppercase tracking-widest text-silver font-medium">Check-out</p>
                                <input
                                    autocomplete="off"
                                    type="date"
                                    name="check_out"
                                    id="check_out"
                                    min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>"
                                    class="w-full text-sm text-ink bg-transparent focus:outline-none mt-0.5 cursor-pointer"
                                />
                            </div>
                        </div>
                        <div class="border-t border-fog px-3 py-2.5">
                            <p class="text-[10px] uppercase tracking-widest text-silver font-medium">Guests</p>
                            <select name="guests" class="w-full text-sm text-ink bg-transparent focus:outline-none mt-0.5 cursor-pointer">
                                <?php for($i = 1; $i <= $listing->max_guests; $i++): ?>
                                    <option value="<?php echo e($i); ?>"><?php echo e($i); ?> <?php echo e(Str::plural('guest', $i)); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <p id="date-error" class="text-xs text-red-500 -mt-2 hidden">Please select both check-in and check-out dates.</p>

                    <button type="submit" class="w-full bg-ink text-white font-medium text-sm rounded-xl py-3.5 hover:bg-carbon transition-colors">
                        Continue to payment
                    </button>
                </form>
                <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="block w-full text-center bg-ink text-white font-medium text-sm rounded-xl py-3.5 hover:bg-carbon transition-colors">
                    Log in to reserve
                </a>
                <?php endif; ?>

                <p class="text-center text-xs text-silver mt-3">You won't be charged yet</p>

                <div class="mt-5 pt-5 border-t border-fog flex flex-col gap-2.5 text-sm">
                    <div class="flex justify-between text-slate">
                        <span>$<?php echo e(number_format($listing->price_per_night / 100, 0)); ?> &times; night</span>
                        <span>varies</span>
                    </div>
                    <div class="flex justify-between text-slate">
                        <span>Cleaning fee</span>
                        <span>$<?php echo e(number_format($listing->cleaning_fee / 100, 0)); ?></span>
                    </div>
                    <div class="flex justify-between font-semibold text-ink pt-2.5 border-t border-fog">
                        <span>Total</span>
                        <span>calculated at checkout</span>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    const form     = document.getElementById('booking-form');
    const checkIn  = document.getElementById('check_in');
    const checkOut = document.getElementById('check_out');
    const dateBox  = document.getElementById('date-box');
    const dateErr  = document.getElementById('date-error');

    if (form) {
        checkIn.addEventListener('change', () => {
            if (checkIn.value) {
                const next = new Date(checkIn.value);
                next.setDate(next.getDate() + 1);
                checkOut.min = next.toISOString().split('T')[0];
                if (checkOut.value && checkOut.value <= checkIn.value) {
                    checkOut.value = '';
                }
            }
        });

        form.addEventListener('submit', (e) => {
            if (!checkIn.value || !checkOut.value) {
                e.preventDefault();
                dateBox.classList.remove('border-fog');
                dateBox.classList.add('border-red-400');
                dateErr.classList.remove('hidden');
                if (!checkIn.value) checkIn.focus();
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Documents\GitHub\property-rental-laravel\property_rental\resources\views/listings/show.blade.php ENDPATH**/ ?>