<header class="relative bg-white">
    <div class="container flex items-center mx-auto px-5 py-4">
        <a href="<?php echo e(request()->is('admin/*') ? route('admin-index') : route('index')); ?>" class="flex items-center mr-auto text-xl font-bold">
            <div class="min-w-10 min-h-10 w-10 h-10 mr-4 bg-contain bg-center bg-no-repeat" style="background-image: url(<?php echo e(asset('images/logo.svg')); ?>)"></div>
            Ali Tour<span class="text-blue">.</span>
        </a>
        <div class="hidden sm:flex items-center">
            <div class="relative flex flex-wrap group">
                <a href="/#regionsSection" class="mr-8 text-black font-medium hover:underline"><?php echo e(__('short-phrases.tours')); ?></a>

                <!-- Tours submenu -->
                <div class="hidden group-hover:block origin-top-right absolute left-0 top-full z-20 w-56 rounded-md shadow-lg bg-white border border-gray-200"
                     role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                    <div class="py-1 rounded-md overflow-hidden" role="none">
                        <?php $__currentLoopData = App\Models\Region::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('region', $region->id)); ?>" class="custom-dropdown-option block px-4 py-2 text-sm text-black cursor-pointer hover:bg-gray-100">
                                <?php echo e($region->name); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <a href="<?php echo e(route('vehicles', ['vehicle_type_id' => 1])); ?>" class="mr-8 text-black font-medium hover:underline"><?php echo e(__('short-phrases.rental-cars')); ?></a>
            <a href="<?php echo e(route('vehicles', ['vehicle_type_id' => 3])); ?>" class="mr-8 text-black font-medium hover:underline"><?php echo e(__('short-phrases.rental-yachts')); ?></a>
            <a href="<?php echo e(route('transfers')); ?>" class="mr-8 text-black font-medium hover:underline"><?php echo e(__('short-phrases.transfers')); ?></a>
            <a href="<?php echo e(route('property')); ?>" class="mr-8 text-black font-medium hover:underline"><?php echo e(__('short-phrases.property')); ?></a>
            <a href="#" class="mr-8 text-black font-medium hover:underline"><?php echo e(__('short-phrases.medical-tourism')); ?></a>
            <a href="/#contacts" class="mr-8 text-black font-medium hover:underline"><?php echo e(__('short-phrases.contacts')); ?></a>
            <?php if(App\Facades\Auth::check()): ?>
                <?php if(!request()->is('admin/*', 'profile/*')): ?>
                    <?php if(in_array(App\Facades\Auth::user()->account_type_id, ['1', '2'])): ?>
                        <a href="<?php echo e(route('profile-index')); ?>" class="text-black font-medium hover:underline">
                            <?php echo e(__('buttons.move-to-cabinet')); ?>

                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('admin-index')); ?>" class="text-black font-medium hover:underline">
                            <?php echo e(__('buttons.admin-panel')); ?>

                        </a>
                    <?php endif; ?>
                <?php endif; ?>
                <a href="<?php echo e(route('logout')); ?>" class="ml-8 text-red font-medium hover:underline"><?php echo e(__('buttons.exit')); ?></a>
            <?php else: ?>
                <div class="show-login-popup-button mr-8 text-black font-medium hover:underline cursor-pointer"><?php echo e(__('buttons.login')); ?></div>
                <div class="show-reg-popup-button text-black font-medium hover:underline cursor-pointer"><?php echo e(__('buttons.reg')); ?></div>
            <?php endif; ?>
                <select class="ml-8 cursor-pointer bg-white text-blue" name="language">
                    <?php $__currentLoopData = ['ru', 'en', 'tr', 'ua']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($lang); ?>" <?php echo e(App::getLocale() === $lang ? 'selected' : ''); ?>><?php echo e(ucfirst($lang)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
        </div>
        <div class="burger-menu-icon block sm:hidden cursor-pointer">
            <svg class="w-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 18L14 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M20 6L10 6" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M20 12L4 12" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <div class="mobile-menu hidden absolute top-full left-0 z-50 w-full pb-10 bg-white shadow-md transition-all duration-150 transform opacity-0 scale-95">
            <div class="grid grid-cols-2 gap-5 px-5 py-6 bg-gray-1000">
                <?php if(App\Facades\Auth::check()): ?>
                    <?php if(!request()->is('admin/*', 'profile/*')): ?>
                        <?php if(in_array(App\Facades\Auth::user()->account_type_id, ['1', '2'])): ?>
                            <a href="<?php echo e(route('profile-index')); ?>" class="flex justify-center px-3 py-1.5 text-sm text-black font-medium bg-white border border-gray-1100 rounded-md">
                                <?php echo e(__('buttons.move-to-cabinet')); ?>

                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('admin-index')); ?>" class="flex justify-center px-3 py-1.5 text-sm text-black font-medium bg-white border border-gray-1100 rounded-md">
                                <?php echo e(__('buttons.admin-panel')); ?>

                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <a href="<?php echo e(route('logout')); ?>" class="<?php echo e(request()->is('admin/*', 'profile/*') ? 'col-span-2' : ''); ?> flex justify-center px-3 py-1.5 text-sm text-red font-medium bg-white border border-gray-1100 rounded-md"><?php echo e(__('buttons.exit')); ?></a>
                <?php else: ?>
                    <div class="show-login-popup-button close-after-click flex justify-center px-3 py-1.5 text-sm text-black font-medium bg-white border border-gray-1100 rounded-md"><?php echo e(__('buttons.login')); ?></div>
                    <div class="show-reg-popup-button close-after-click flex justify-center px-3 py-1.5 text-sm text-black font-medium bg-white border border-gray-1100 rounded-md"><?php echo e(__('buttons.reg')); ?></div>
                <?php endif; ?>
            </div>
            <div class="flex flex-col items-center mb-5 p-5">
                <a href="<?php echo e(route('index')); ?>" class="mb-4 text-sm text-black font-semibold"><?php echo e(__('short-phrases.main')); ?></a>
                <a href="/#regionsSection" class="close-after-click mb-4 text-sm text-black font-semibold"><?php echo e(__('short-phrases.popular-regions')); ?></a>
                <div class="flex flex-col mb-4 group">
                    <div class="flex items-center">
                        <p class="mr-3 text-sm text-black font-semibold"><?php echo e(__('short-phrases.tours')); ?></p>
                        <svg width="11" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L5 5L9 1" stroke="#231F20" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <div class="hidden group-hover:flex flex-col mt-4">
                        <?php $__currentLoopData = App\Models\Region::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('region', $region->id)); ?>" class="mb-4 text-sm text-center text-black font-medium"><?php echo e($region->name); ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <a href="<?php echo e(route('vehicles', ['vehicle_type_id' => 1])); ?>" class="mb-4 text-sm text-black font-semibold"><?php echo e(__('short-phrases.cars-rental')); ?></a>
                <a href="<?php echo e(route('vehicles', ['vehicle_type_id' => 3])); ?>" class="mb-4 text-sm text-black font-semibold"><?php echo e(__('short-phrases.yachts-rental')); ?></a>
                <a href="<?php echo e(route('transfers')); ?>" class="mb-4 text-sm text-black font-semibold"><?php echo e(__('short-phrases.transfers')); ?></a>
                <a href="<?php echo e(route('property')); ?>" class="mb-4 text-sm text-black font-semibold"><?php echo e(__('short-phrases.property')); ?></a>
                <a href="#" class="mb-4 text-sm text-black font-semibold"><?php echo e(__('short-phrases.medical-tourism')); ?></a>
                <a href="/#reviewsSliderSection" class="close-after-click mb-4 text-sm text-black font-semibold"><?php echo e(__('short-phrases.reviews')); ?></a>
                <a href="/#contacts" class="close-after-click mb-4 text-sm text-black font-semibold"><?php echo e(__('short-phrases.contacts')); ?></a>
                <select class="text-sm text-black font-semibold bg-white" name="language">
                    <?php $__currentLoopData = ['ru', 'en', 'tr', 'ua']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($lang); ?>" <?php echo e(App::getLocale() === $lang ? 'selected' : ''); ?>><?php echo e(ucfirst($lang)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="flex justify-center">
                <a href="https://wa.me/+905350303054" target="_blank" class="w-8 h-8 bg-contain bg-center bg-no-repeat" style="background-image: url(<?php echo e(asset('images/whatsapp-icon.svg')); ?>)"></a>
                <a href="https://t.me/alitasin" target="_blank" class="w-8 h-8 mx-8 bg-contain bg-center bg-no-repeat" style="background-image: url(<?php echo e(asset('images/telegram-icon.svg')); ?>)"></a>
                <a href="viber://add?number=905350303054" class="w-8 h-8 bg-contain bg-center bg-no-repeat" style="background-image: url(<?php echo e(asset('images/phone-icon.svg')); ?>)"></a>
            </div>
        </div>
    </div>
</header>
<?php /**PATH /Users/butingeorgiy/Workspace/Dev/www-root/alitasin/resources/views/components/general/header.blade.php ENDPATH**/ ?>