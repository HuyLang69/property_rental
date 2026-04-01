<?php $__env->startSection('title', 'Payment — NestAway'); ?>

<?php $__env->startSection('content'); ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <div class="mb-8">
        <a href="<?php echo e(route('listings.show', $listing->id)); ?>" class="flex items-center gap-2 text-sm text-silver hover:text-ink transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/></svg>
            Back to listing
        </a>
        <h1 class="font-display text-3xl font-bold tracking-tight text-ink">Confirm and pay</h1>
    </div>

    <div class="flex flex-col lg:flex-row gap-10">

        
        <div class="flex-1">

            
            <div class="bg-white border border-fog rounded-2xl p-5 mb-6 flex items-center gap-4">
                <div class="w-20 h-16 rounded-xl overflow-hidden shrink-0 bg-fog">
                    <?php if($listing->coverImage): ?>
                        <img src="<?php echo e($listing->coverImage->path); ?>" class="w-full h-full object-cover" />
                    <?php endif; ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-ink truncate"><?php echo e($listing->title); ?></p>
                    <p class="text-xs text-silver mt-0.5"><?php echo e($listing->city); ?>, <?php echo e($listing->country); ?></p>
                    <p class="text-xs text-slate mt-1">
                        <?php echo e(\Carbon\Carbon::parse($checkIn)->format('M d')); ?> — <?php echo e(\Carbon\Carbon::parse($checkOut)->format('M d, Y')); ?>

                        &middot; <?php echo e($nights); ?> <?php echo e(Str::plural('night', $nights)); ?>

                        &middot; <?php echo e($guests); ?> <?php echo e(Str::plural('guest', $guests)); ?>

                    </p>
                </div>
            </div>

            
            <form action="<?php echo e(route('bookings.store')); ?>" method="POST" id="payment-form" class="flex flex-col gap-6">
                <?php echo csrf_field(); ?>

                
                <input type="hidden" name="listing_id" value="<?php echo e($listing->id); ?>" />
                <input type="hidden" name="check_in"   value="<?php echo e($checkIn); ?>" />
                <input type="hidden" name="check_out"  value="<?php echo e($checkOut); ?>" />
                <input type="hidden" name="guests"     value="<?php echo e($guests); ?>" />

                
                <div class="bg-white border border-fog rounded-2xl p-6 flex flex-col gap-5">

                    <div class="flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-ink uppercase tracking-widest">Payment details</h2>
                        <div class="flex items-center gap-2">
                            
                            <div class="w-8 h-5 bg-[#1a1f71] rounded flex items-center justify-center">
                                <span class="text-[7px] font-black text-white tracking-tight">VISA</span>
                            </div>
                            <div class="w-8 h-5 rounded overflow-hidden flex">
                                <div class="w-1/2 bg-[#eb001b]"></div>
                                <div class="w-1/2 bg-[#f79e1b]"></div>
                            </div>
                            <div class="w-8 h-5 bg-[#2557D6] rounded flex items-center justify-center">
                                <span class="text-[6px] font-black text-white">AMEX</span>
                            </div>
                        </div>
                    </div>

                    
                    <div class="flex flex-col gap-1.5">
                        <label for="cardholder_name" class="text-xs font-medium text-slate uppercase tracking-widest">Cardholder name</label>
                        <input
                            autocomplete="off"
                            id="cardholder_name"
                            type="text"
                            name="cardholder_name"
                            placeholder="Jane Doe"
                            value="<?php echo e(old('cardholder_name')); ?>"
                            required
                            class="border border-fog rounded-xl px-4 py-3 text-sm text-ink placeholder-silver bg-cream focus:border-ink focus:outline-none transition-colors"
                        />
                        <?php $__errorArgs = ['cardholder_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-xs text-red-500"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="flex flex-col gap-1.5">
                        <label for="card_number" class="text-xs font-medium text-slate uppercase tracking-widest">Card number</label>
                        <div class="relative">
                            <input
                                autocomplete="off"
                                id="card_number"
                                type="text"
                                name="card_number"
                                placeholder="0000 0000 0000 0000"
                                maxlength="19"
                                required
                                class="w-full border border-fog rounded-xl px-4 py-3 pr-12 text-sm text-ink placeholder-silver bg-cream focus:border-ink focus:outline-none transition-colors tracking-widest"
                            />
                            <svg id="card-icon" class="w-5 h-5 text-silver absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                            </svg>
                        </div>
                        <?php $__errorArgs = ['card_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-xs text-red-500"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label for="expiry" class="text-xs font-medium text-slate uppercase tracking-widest">Expiry date</label>
                            <input
                                autocomplete="off"
                                id="expiry"
                                type="text"
                                name="expiry"
                                placeholder="MM / YY"
                                maxlength="7"
                                required
                                class="border border-fog rounded-xl px-4 py-3 text-sm text-ink placeholder-silver bg-cream focus:border-ink focus:outline-none transition-colors"
                            />
                            <?php $__errorArgs = ['expiry'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-xs text-red-500"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="cvv" class="text-xs font-medium text-slate uppercase tracking-widest">
                                CVV
                                <span class="ml-1 cursor-help text-silver" title="3-digit code on the back of your card (4 digits for Amex)">?</span>
                            </label>
                            <input
                                autocomplete="off"
                                id="cvv"
                                type="text"
                                name="cvv"
                                placeholder="•••"
                                maxlength="4"
                                required
                                class="border border-fog rounded-xl px-4 py-3 text-sm text-ink placeholder-silver bg-cream focus:border-ink focus:outline-none transition-colors"
                            />
                            <?php $__errorArgs = ['cvv'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-xs text-red-500"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                </div>

                
                <div class="bg-white border border-fog rounded-2xl p-6 flex flex-col gap-5">
                    <h2 class="text-sm font-semibold text-ink uppercase tracking-widest">Billing address</h2>

                    <div class="flex flex-col gap-1.5">
                        <label for="billing_name" class="text-xs font-medium text-slate uppercase tracking-widest">Full name</label>
                        <input autocomplete="off" id="billing_name" type="text" name="billing_name"
                               placeholder="Jane Doe"
                               value="<?php echo e(old('billing_name', Auth::user()->full_name)); ?>"
                               required
                               class="border border-fog rounded-xl px-4 py-3 text-sm text-ink placeholder-silver bg-cream focus:border-ink focus:outline-none transition-colors" />
                        <?php $__errorArgs = ['billing_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-xs text-red-500"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="billing_address" class="text-xs font-medium text-slate uppercase tracking-widest">Street address</label>
                        <input autocomplete="off" id="billing_address" type="text" name="billing_address"
                               placeholder="123 Main St"
                               value="<?php echo e(old('billing_address')); ?>"
                               required
                               class="border border-fog rounded-xl px-4 py-3 text-sm text-ink placeholder-silver bg-cream focus:border-ink focus:outline-none transition-colors" />
                        <?php $__errorArgs = ['billing_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-xs text-red-500"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label for="billing_city" class="text-xs font-medium text-slate uppercase tracking-widest">City</label>
                            <input autocomplete="off" id="billing_city" type="text" name="billing_city"
                                   placeholder="Lisbon"
                                   value="<?php echo e(old('billing_city')); ?>"
                                   required
                                   class="border border-fog rounded-xl px-4 py-3 text-sm text-ink placeholder-silver bg-cream focus:border-ink focus:outline-none transition-colors" />
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label for="billing_zip" class="text-xs font-medium text-slate uppercase tracking-widest">Postal code</label>
                            <input autocomplete="off" id="billing_zip" type="text" name="billing_zip"
                                   placeholder="1000-001"
                                   value="<?php echo e(old('billing_zip')); ?>"
                                   required
                                   class="border border-fog rounded-xl px-4 py-3 text-sm text-ink placeholder-silver bg-cream focus:border-ink focus:outline-none transition-colors" />
                        </div>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="billing_country" class="text-xs font-medium text-slate uppercase tracking-widest">Country</label>
                        <select autocomplete="off" id="billing_country" name="billing_country"
                                class="border border-fog rounded-xl px-4 py-3 text-sm text-ink bg-cream focus:border-ink focus:outline-none transition-colors">
                            <option value="PT" selected>Portugal</option>
                            <option value="ES">Spain</option>
                            <option value="FR">France</option>
                            <option value="GB">United Kingdom</option>
                            <option value="DE">Germany</option>
                            <option value="US">United States</option>
                            <option value="BR">Brazil</option>
                            <option value="OTHER">Other</option>
                        </select>
                    </div>
                </div>

                
                <div class="flex items-center gap-2 text-xs text-silver">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                    </svg>
                    Your payment info is encrypted and never stored on our servers.
                </div>

                <button type="submit" id="submit-btn"
                        class="w-full bg-ink text-white font-semibold text-sm rounded-xl py-4 hover:bg-carbon transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                    </svg>
                    Confirm and pay $<?php echo e(number_format($total / 100, 2)); ?>

                </button>

                <p class="text-center text-xs text-silver">
                    By confirming, you agree to our
                    <a href="<?php echo e(url('/terms')); ?>" class="text-ink hover:underline">Terms of Service</a>
                    and
                    <a href="<?php echo e(url('/privacy')); ?>" class="text-ink hover:underline">Cancellation Policy</a>.
                </p>

            </form>
        </div>

        
        <div class="w-full lg:w-80 shrink-0">
            <div class="sticky top-24 bg-white border border-fog rounded-2xl p-6">

                <h2 class="text-sm font-semibold text-ink uppercase tracking-widest mb-5">Price breakdown</h2>

                <div class="flex flex-col gap-3 text-sm">
                    <div class="flex justify-between text-slate">
                        <span>$<?php echo e(number_format($listing->price_per_night / 100, 2)); ?> &times; <?php echo e($nights); ?> <?php echo e(Str::plural('night', $nights)); ?></span>
                        <span>$<?php echo e(number_format(($listing->price_per_night * $nights) / 100, 2)); ?></span>
                    </div>
                    <div class="flex justify-between text-slate">
                        <span>Cleaning fee</span>
                        <span>$<?php echo e(number_format($listing->cleaning_fee / 100, 2)); ?></span>
                    </div>
                    <div class="flex justify-between text-slate">
                        <span>Service fee (12%)</span>
                        <span>$<?php echo e(number_format($serviceFee / 100, 2)); ?></span>
                    </div>
                    <div class="border-t border-fog pt-3 flex justify-between font-semibold text-ink">
                        <span>Total (USD)</span>
                        <span>$<?php echo e(number_format($total / 100, 2)); ?></span>
                    </div>
                </div>

                <div class="mt-5 pt-5 border-t border-fog flex items-start gap-2 text-xs text-silver leading-relaxed">
                    <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                    </svg>
                    You won't be charged until the host confirms your booking.
                </div>
            </div>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // ── Card number formatting ──────────────────────────────────
    const cardInput = document.getElementById('card_number');
    cardInput.addEventListener('input', (e) => {
        let val = e.target.value.replace(/\D/g, '').slice(0, 16);
        e.target.value = val.match(/.{1,4}/g)?.join(' ') ?? val;
    });

    // ── Expiry formatting ───────────────────────────────────────
    const expiryInput = document.getElementById('expiry');
    expiryInput.addEventListener('input', (e) => {
        let val = e.target.value.replace(/\D/g, '').slice(0, 4);
        if (val.length >= 2) val = val.slice(0, 2) + ' / ' + val.slice(2);
        e.target.value = val;
    });

    // ── CVV: digits only ────────────────────────────────────────
    const cvvInput = document.getElementById('cvv');
    cvvInput.addEventListener('input', (e) => {
        e.target.value = e.target.value.replace(/\D/g, '').slice(0, 4);
    });

    // ── Prevent double submit ───────────────────────────────────
    document.getElementById('payment-form').addEventListener('submit', () => {
        const btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.textContent = 'Processing…';
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Documents\GitHub\property-rental-laravel\property_rental\resources\views/billing/payment.blade.php ENDPATH**/ ?>