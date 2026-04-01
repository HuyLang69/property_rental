<?php $__env->startSection('title', 'Edit Listing — NestAway'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    
    <div class="mb-10 fade-up">
        <p class="text-xs uppercase tracking-widest text-silver mb-1">Host</p>
        <h1 class="font-display text-4xl font-bold tracking-tight text-ink">Edit listing</h1>
        <p class="mt-2 text-sm text-slate"><?php echo e($listing->title); ?></p>
    </div>

    <?php if(session('success')): ?>
    <div class="flex items-center gap-3 bg-white border border-fog rounded-2xl px-4 py-3 mb-6 fade-up">
        <svg class="w-4 h-4 text-ink shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        <p class="text-sm text-ink"><?php echo e(session('success')); ?></p>
    </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
    <div class="bg-red-50 border border-red-100 rounded-2xl px-5 py-4 mb-8 fade-up">
        <p class="text-sm font-semibold text-red-500 mb-2">Please fix the following errors:</p>
        <ul class="list-disc list-inside space-y-1">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="text-sm text-red-400"><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>

    <form action="<?php echo e(route('listings.update', $listing)); ?>" method="POST"
          enctype="multipart/form-data" autocomplete="off"
          class="flex flex-col gap-8">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
        <div class="bg-white border border-fog rounded-2xl p-6 fade-up d1">
            <h2 class="text-sm font-semibold text-ink uppercase tracking-widest mb-5">Basic info</h2>

            <div class="flex flex-col gap-5">
                
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="title">Title</label>
                    <input type="text" id="title" name="title"
                           value="<?php echo e(old('title', $listing->title)); ?>"
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
                        <?php $__currentLoopData = ['apartment', 'house', 'studio', 'villa', 'room']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($t); ?>"
                                <?php echo e(old('type', $listing->type) === $t ? 'selected' : ''); ?>>
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
                              autocomplete="off"
                              class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink placeholder-silver
                                     focus:border-ink focus:outline-none transition-colors resize-none
                                     <?php echo e($errors->has('description') ? 'border-red-300' : ''); ?>"><?php echo e(old('description', $listing->description)); ?></textarea>
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
                           value="<?php echo e(old('city', $listing->city)); ?>"
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
                           value="<?php echo e(old('country', $listing->country)); ?>"
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
                           value="<?php echo e(old('address', $listing->address)); ?>"
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

        
        <div class="bg-white border border-fog rounded-2xl p-6 fade-up d2">
            <h2 class="text-sm font-semibold text-ink uppercase tracking-widest mb-5">Details</h2>

            <div class="grid grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5" for="bedrooms">Bedrooms</label>
                    <input type="number" id="bedrooms" name="bedrooms"
                           value="<?php echo e(old('bedrooms', $listing->bedrooms)); ?>"
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
                           value="<?php echo e(old('bathrooms', $listing->bathrooms)); ?>"
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
                           value="<?php echo e(old('max_guests', $listing->max_guests)); ?>"
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
                           value="<?php echo e(old('price_per_night', $listing->price_per_night / 100)); ?>"
                           min="1" max="99999" step="0.01"
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
                           value="<?php echo e(old('cleaning_fee', $listing->cleaning_fee / 100)); ?>"
                           min="0" max="9999" step="0.01"
                           autocomplete="off"
                           class="w-full border border-fog rounded-xl px-4 py-2.5 text-sm text-ink placeholder-silver
                                  focus:border-ink focus:outline-none transition-colors" />
                </div>
            </div>
        </div>

        
        <?php if($listing->images->isNotEmpty()): ?>
        <div class="bg-white border border-fog rounded-2xl p-6 fade-up d3">
            <h2 class="text-sm font-semibold text-ink uppercase tracking-widest mb-1">Current photos</h2>
            <p class="text-xs text-silver mb-5">Tick a photo to remove it when you save.</p>

            <div class="grid grid-cols-3 sm:grid-cols-5 gap-3">
                <?php $__currentLoopData = $listing->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="relative aspect-square cursor-pointer group" title="Delete this photo">
                    <img src="<?php echo e(asset('storage/' . $image->path)); ?>"
                         alt="Photo"
                         class="w-full h-full object-cover rounded-xl transition-opacity group-has-[:checked]:opacity-40" />
                    <?php if($image->is_cover): ?>
                        <span class="absolute bottom-1 left-1 text-[10px] font-semibold bg-ink text-white
                                     rounded-full px-2 py-0.5 pointer-events-none group-has-[:checked]:opacity-0">
                            Cover
                        </span>
                    <?php endif; ?>
                    <input type="checkbox" name="delete_images[]"
                           value="<?php echo e($image->id); ?>"
                           class="absolute top-1.5 right-1.5 w-4 h-4 rounded accent-red-500 opacity-0 group-hover:opacity-100 group-has-[:checked]:opacity-100 transition-opacity" />
                    <div class="absolute inset-0 rounded-xl ring-2 ring-red-400 opacity-0 group-has-[:checked]:opacity-100 transition-opacity pointer-events-none"></div>
                    <span class="absolute top-1.5 left-1.5 text-[10px] bg-red-500 text-white rounded-full px-2 py-0.5
                                 opacity-0 group-has-[:checked]:opacity-100 transition-opacity pointer-events-none font-semibold">
                        Delete
                    </span>
                </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

        
        <div class="bg-white border border-fog rounded-2xl p-6 fade-up d4">
            <h2 class="text-sm font-semibold text-ink uppercase tracking-widest mb-1">Add photos</h2>
            <p class="text-xs text-silver mb-5">Optional. JPG, PNG or WebP, max 4 MB each.</p>

            <label for="images"
                   class="flex flex-col items-center justify-center gap-3 border-2 border-dashed border-fog
                          rounded-xl py-8 px-4 cursor-pointer hover:border-silver transition-colors">
                <svg class="w-7 h-7 text-silver" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 3h18M3 21h18M13.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                </svg>
                <span class="text-sm text-slate">Click to add more photos</span>
                <span id="file-count" class="text-xs text-silver"></span>
                <input id="images" type="file" name="images[]"
                       multiple accept="image/jpeg,image/png,image/webp"
                       autocomplete="off"
                       class="sr-only"
                       onchange="previewImages(this)" />
            </label>

            <div id="preview-grid" class="grid grid-cols-3 sm:grid-cols-5 gap-2 mt-4"></div>
        </div>

        
        <div class="bg-white border border-fog rounded-2xl p-6 fade-up d4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-ink">Available for booking</p>
                    <p class="text-xs text-silver mt-0.5">Uncheck to hide this listing from guests.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="is_available" value="0" />
                    <input type="checkbox" id="is_available" name="is_available" value="1"
                           <?php echo e(old('is_available', $listing->is_available ? '1' : '0') == '1' ? 'checked' : ''); ?>

                           class="sr-only peer" />
                    <div class="w-11 h-6 bg-fog rounded-full peer peer-checked:bg-ink transition-colors"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                </label>
            </div>
        </div>

        
        <div class="flex items-center justify-between fade-up d5">
            
            <button type="button" id="open-delete-modal"
                    class="text-sm text-red-400 hover:text-red-500 transition-colors">
                Delete listing
            </button>

            <div class="flex items-center gap-4">
                <a href="<?php echo e(route('listings.show', $listing)); ?>"
                   class="text-sm text-silver hover:text-ink transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-ink text-white text-sm font-medium rounded-full px-8 py-3
                               hover:bg-carbon transition-colors">
                    Save changes
                </button>
            </div>
        </div>

    </form>

    
    <div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center px-4">
        <div class="absolute inset-0 bg-ink/40 backdrop-blur-sm" id="delete-backdrop"></div>
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 flex flex-col gap-5">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-ink">Delete this listing?</h3>
                    <p class="text-sm text-slate mt-1 leading-relaxed">
                        <?php echo e($listing->title); ?><br>
                        All photos will be permanently removed.
                    </p>
                    <p class="text-xs text-silver mt-2">This action cannot be undone.</p>
                </div>
            </div>
            <div class="flex gap-3">
                <button type="button" id="close-delete-modal"
                        class="flex-1 border border-fog rounded-xl py-2.5 text-sm font-medium text-slate
                               hover:border-ink hover:text-ink transition-colors">
                    Keep listing
                </button>
                <form action="<?php echo e(route('listings.destroy', $listing)); ?>" method="POST" class="flex-1">
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

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Delete modal
    const modal    = document.getElementById('delete-modal');
    const backdrop = document.getElementById('delete-backdrop');

    document.getElementById('open-delete-modal').addEventListener('click', () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    });

    function closeDeleteModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    document.getElementById('close-delete-modal').addEventListener('click', closeDeleteModal);
    backdrop.addEventListener('click', closeDeleteModal);

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeDeleteModal();
    });

    // New photo preview
    function previewImages(input) {
        const grid  = document.getElementById('preview-grid');
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

                wrap.appendChild(img);
                grid.appendChild(wrap);
            };
            reader.readAsDataURL(file);
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Documents\GitHub\property-rental-laravel\property_rental\resources\views/listings/edit.blade.php ENDPATH**/ ?>