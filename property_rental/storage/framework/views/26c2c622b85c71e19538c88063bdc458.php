<?php $__env->startSection('title', 'List Your Property — NestAway'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    
    <div class="mb-10 fade-up">
        <p class="text-xs uppercase tracking-widest text-silver mb-1">Host</p>
        <h1 class="font-display text-4xl font-bold tracking-tight text-ink">List your property</h1>
        <p class="mt-2 text-sm text-slate">Fill in the details below. You can always edit later.</p>
    </div>

    <?php if($errors->any()): ?>
    <div class="bg-red-50 border border-red-100 rounded-2xl px-5 py-4 mb-8 fade-up d1">
        <p class="text-sm font-semibold text-red-500 mb-2">Please fix the following errors:</p>
        <ul class="list-disc list-inside space-y-1">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="text-sm text-red-400"><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>

    <form action="<?php echo e(route('listings.store')); ?>" method="POST"
          enctype="multipart/form-data" autocomplete="off"
          class="flex flex-col gap-8">
        <?php echo csrf_field(); ?>

        
        <div class="bg-white border border-fog rounded-2xl p-6 fade-up d1">
            <h2 class="text-sm font-semibold text-ink uppercase tracking-widest mb-5">Basic info</h2>

            <div class="flex flex-col gap-5">
                
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="title">Title</label>
                    <input type="text" id="title" name="title"
                           value="<?php echo e(old('title')); ?>"
                           placeholder="e.g. Bright studio in central Lisbon"
                           autocomplete="off"
                           class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink placeholder-silver
                                  focus:border-ink focus:outline-none transition-colors
                                  <?php echo e($errors->has('title') ? 'border-red-300' : ''); ?>" />
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="type">Property type</label>
                    <select id="type" name="type"
                            class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink bg-white
                                   focus:border-ink focus:outline-none transition-colors
                                   <?php echo e($errors->has('type') ? 'border-red-300' : ''); ?>">
                        <option value="">Select type…</option>
                        <?php $__currentLoopData = ['apartment', 'house', 'studio', 'villa', 'room']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($t); ?>" <?php echo e(old('type') === $t ? 'selected' : ''); ?>>
                                <?php echo e(ucfirst($t)); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="description">Description</label>
                    <textarea id="description" name="description" rows="5"
                              placeholder="Describe your space, the neighbourhood, what makes it special…"
                              autocomplete="off"
                              class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink placeholder-silver
                                     focus:border-ink focus:outline-none transition-colors resize-none
                                     <?php echo e($errors->has('description') ? 'border-red-300' : ''); ?>"><?php echo e(old('description')); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>

        
        <div class="bg-white border border-fog rounded-2xl p-6 fade-up d2">
            <h2 class="text-sm font-semibold text-ink uppercase tracking-widest mb-5">Location</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="city">City</label>
                    <input type="text" id="city" name="city"
                           value="<?php echo e(old('city')); ?>"
                           placeholder="Lisbon"
                           autocomplete="off"
                           class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink placeholder-silver
                                  focus:border-ink focus:outline-none transition-colors
                                  <?php echo e($errors->has('city') ? 'border-red-300' : ''); ?>" />
                    <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="country">Country</label>
                    <input type="text" id="country" name="country"
                           value="<?php echo e(old('country')); ?>"
                           placeholder="Portugal"
                           autocomplete="off"
                           class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink placeholder-silver
                                  focus:border-ink focus:outline-none transition-colors
                                  <?php echo e($errors->has('country') ? 'border-red-300' : ''); ?>" />
                    <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-ink mb-1.5" for="address">Address</label>
                    <input type="text" id="address" name="address"
                           value="<?php echo e(old('address')); ?>"
                           placeholder="Rua Augusta, 28"
                           autocomplete="off"
                           class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink placeholder-silver
                                  focus:border-ink focus:outline-none transition-colors
                                  <?php echo e($errors->has('address') ? 'border-red-300' : ''); ?>" />
                    <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>

        
        <div class="bg-white border border-fog rounded-2xl p-6 fade-up d3">
            <h2 class="text-sm font-semibold text-ink uppercase tracking-widest mb-5">Details</h2>

            <div class="grid grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="bedrooms">Bedrooms</label>
                    <input type="number" id="bedrooms" name="bedrooms"
                           value="<?php echo e(old('bedrooms', 1)); ?>"
                           min="0" max="50"
                           autocomplete="off"
                           class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink
                                  focus:border-ink focus:outline-none transition-colors
                                  <?php echo e($errors->has('bedrooms') ? 'border-red-300' : ''); ?>" />
                    <?php $__errorArgs = ['bedrooms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="bathrooms">Bathrooms</label>
                    <input type="number" id="bathrooms" name="bathrooms"
                           value="<?php echo e(old('bathrooms', 1)); ?>"
                           min="0" max="50"
                           autocomplete="off"
                           class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink
                                  focus:border-ink focus:outline-none transition-colors
                                  <?php echo e($errors->has('bathrooms') ? 'border-red-300' : ''); ?>" />
                    <?php $__errorArgs = ['bathrooms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="max_guests">Max guests</label>
                    <input type="number" id="max_guests" name="max_guests"
                           value="<?php echo e(old('max_guests', 2)); ?>"
                           min="1" max="50"
                           autocomplete="off"
                           class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink
                                  focus:border-ink focus:outline-none transition-colors
                                  <?php echo e($errors->has('max_guests') ? 'border-red-300' : ''); ?>" />
                    <?php $__errorArgs = ['max_guests'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>

        
        <div class="bg-white border border-fog rounded-2xl p-6 fade-up d3">
            <h2 class="text-sm font-semibold text-ink uppercase tracking-widest mb-5">Pricing</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="price_per_night">Price per night (€)</label>
                    <input type="number" id="price_per_night" name="price_per_night"
                           value="<?php echo e(old('price_per_night')); ?>"
                           min="1" max="99999" step="0.01"
                           placeholder="85.00"
                           autocomplete="off"
                           class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink placeholder-silver
                                  focus:border-ink focus:outline-none transition-colors
                                  <?php echo e($errors->has('price_per_night') ? 'border-red-300' : ''); ?>" />
                    <?php $__errorArgs = ['price_per_night'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="cleaning_fee">
                        Cleaning fee (€) <span class="text-silver font-normal">optional</span>
                    </label>
                    <input type="number" id="cleaning_fee" name="cleaning_fee"
                           value="<?php echo e(old('cleaning_fee')); ?>"
                           min="0" max="9999" step="0.01"
                           placeholder="0.00"
                           autocomplete="off"
                           class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink placeholder-silver
                                  focus:border-ink focus:outline-none transition-colors" />
                </div>
            </div>
        </div>

        
        <div class="bg-white border border-fog rounded-2xl p-6 fade-up d4">
            <h2 class="text-sm font-semibold text-ink uppercase tracking-widest mb-1">Photos</h2>
            <p class="text-xs text-silver mb-5">Add 1–10 photos. First photo will be the cover. JPG, PNG or WebP, max 4 MB each.</p>

            <label for="images"
                   class="flex flex-col items-center justify-center gap-3 border-2 border-dashed border-fog
                          rounded-xl py-10 px-4 cursor-pointer hover:border-silver transition-colors
                          <?php echo e($errors->has('images') || $errors->has('images.*') ? 'border-red-300' : ''); ?>">
                <svg class="w-8 h-8 text-silver" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 3h18M3 21h18M13.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                </svg>
                <span class="text-sm text-slate">Click to choose photos</span>
                <span id="file-count" class="text-xs text-silver"></span>
                <input id="images" type="file" name="images[]"
                       multiple accept="image/jpeg,image/png,image/webp"
                       autocomplete="off"
                       class="sr-only"
                       onchange="previewImages(this)" />
            </label>

            <?php $__errorArgs = ['images'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-2 text-xs text-red-500"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            
            <div id="preview-grid" class="grid grid-cols-3 sm:grid-cols-5 gap-2 mt-4"></div>
        </div>

        
        <div class="bg-white border border-fog rounded-2xl p-6 fade-up d4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-ink">Available for booking</p>
                    <p class="text-xs text-silver mt-0.5">Uncheck to hide this listing while you prepare it.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="is_available" value="0" />
                    <input type="checkbox" id="is_available" name="is_available" value="1"
                           <?php echo e(old('is_available', '1') == '1' ? 'checked' : ''); ?>

                           class="sr-only peer" />
                    <div class="w-11 h-6 bg-fog rounded-full peer peer-checked:bg-ink transition-colors"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                </label>
            </div>
        </div>

        
        <div class="flex items-center justify-between fade-up d5">
            <a href="<?php echo e(route('host.bookings')); ?>"
               class="text-sm text-silver hover:text-ink transition-colors">
                Cancel
            </a>
            <button type="submit"
                    class="bg-ink text-white text-sm font-medium rounded-full px-8 py-3
                           hover:bg-carbon transition-colors">
                Publish listing
            </button>
        </div>

    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    function previewImages(input) {
        const grid = document.getElementById('preview-grid');
        const count = document.getElementById('file-count');
        grid.innerHTML = '';

        const files = Array.from(input.files);
        count.textContent = files.length === 0
            ? ''
            : `${files.length} photo${files.length > 1 ? 's' : ''} selected`;

        files.forEach((file, i) => {
            const reader = new FileReader();
            reader.onload = e => {
                const wrap = document.createElement('div');
                wrap.className = 'relative aspect-square rounded-xl overflow-hidden bg-fog';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-full object-cover';

                if (i === 0) {
                    const badge = document.createElement('div');
                    badge.textContent = 'Cover';
                    badge.className = 'absolute bottom-1 left-1 text-[10px] font-semibold bg-ink text-white rounded-full px-2 py-0.5';
                    wrap.appendChild(badge);
                }
                wrap.appendChild(img);
                grid.appendChild(wrap);
            };
            reader.readAsDataURL(file);
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Documents\GitHub\property-rental-laravel\property_rental\resources\views/listings/create.blade.php ENDPATH**/ ?>