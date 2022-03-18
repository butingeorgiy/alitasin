<!doctype html>
<html lang='<?php echo e(app()->getLocale()); ?>'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport'
          content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <script type='text/javascript' src='<?php echo e(asset('js/index.js')); ?>'></script>
    <link rel='stylesheet' href='<?php echo e(asset('css/index.css')); ?>'>
    <link rel="icon" href="<?php echo e(asset('images/favicon.ico')); ?>">
    <title><?php echo e(__('page-titles.vehicles')); ?></title>
</head>
<body>
    <?php echo $__env->make('components.general.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.general.hero', ['title' => __('short-phrases.transport-rental'), 'image' => asset('images/vehicles-hero-bg.png')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.index.global-search', ['bottomBorder' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <section id="vehicleTypesSection" class="mb-10 pb-4 sm:pb-6 border-b border-gray-200">
        <div class="container mx-auto px-5">
            <p class="mb-4 text-black"><?php echo e(__('short-phrases.vehicle-region-warning')); ?></p>

            <div class="flex items-center mb-10 text-xl">
                <span class="font-semibold"><?php echo e(__('short-phrases.choose-region')); ?>:&nbsp;&nbsp;</span>
                <select class="placeholder-gray-800 text-blue bg-white font-semibold cursor-pointer" name="region_id">
                    <option value=""><?php echo e(__('short-phrases.any')); ?></option>
                    <?php $__currentLoopData = App\Models\Region::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($region->id); ?>" <?php echo e((string) $region->id === request()->input('region_id', '') ? 'selected' : ''); ?>>
                            <?php echo e($region->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="mb-2 sm:mb-4">
                <p class="inline text-black text-2xl font-bold text-black"><?php echo e(__('short-phrases.vehicle-categories')); ?><span class="text-blue">.</span></p>
            </div>

            <?php $vehicleTypes = App\Models\VehicleType::all(); ?>

            <div class="hidden sm:grid grid-cols-2 lg:grid-cols-4 gap-4">
                <?php $__currentLoopData = $vehicleTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('vehicles', ['vehicle_type_id' => $item->id])); ?>"
                       class="flex justify-center items-center text-white text-3xl font-semibold tracking-wide bg-cover bg-center bg-no-repeat shadow rounded-md
                       <?php echo e((int) request()->input('vehicle_type_id') === $item->id ? 'underline' : ''); ?>"
                       style="height: 180px; background-image: url(<?php echo e($item->image); ?>)">
                        <span><?php echo e($item->name); ?></span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="block sm:hidden swiper-container -mx-3">
                <div class="swiper-wrapper -mx-2 px-5 py-2">
                    <?php $__currentLoopData = $vehicleTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('vehicles', ['vehicle_type_id' => $item->id])); ?>"
                           class="swiper-slide relative flex justify-center items-center w-72 text-white text-3xl font-bold tracking-wide bg-center bg-cover bg-no-repeat rounded-md
                           <?php echo e((int) request()->input('vehicle_type_id') === $item->id ? 'underline' : ''); ?>"
                           style="height: 180px; background-image: url(<?php echo e($item->image); ?>)"><?php echo e($item->name); ?></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </section>

    <section id="vehicleSection" class="pb-10">
        <div class="container flex flex-col mx-auto px-5">
            <?php /** @var App\Models\Vehicle $vehicle */ ?>
            <?php $__empty_1 = true; $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="vehicle-item grid grid-cols-12 mb-5 last:mb-0 bg-gray-1200 rounded-md shadow"
                     data-id="<?php echo e($vehicle->id); ?>"
                     data-region="<?php echo e($vehicle->region->name); ?>"
                     data-price="<?php echo e($vehicle->cost); ?>"
                     data-title="<?php echo e($vehicle->brand); ?> (<?php echo e($vehicle->model); ?>)">
                    <div class="col-span-full lg:col-span-5 relative flex flex-col items-center px-8 sm:px-16 pt-8 sm:pt-12 lg:pb-12 lg:border-r border-gray-1300">
                        <div class="show-vehicle-gallery-btn w-full h-44 bg-contain bg-center bg-no-repeat cursor-pointer"
                             data-images="<?php echo e(json_encode($vehicle->getAllImagesUrl())); ?>"
                             style="background-image: url(<?php echo e($vehicle->main_image); ?>)">
                            <svg class="absolute min-h-6 min-w-6 h-6 w-6 bottom-5 right-5 text-blue"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0
                                  0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                            </svg>
                        </div>
                        <?php if(App\Facades\Auth::check(['5'])): ?>
                            <div class="flex absolute bottom-4">
                                <a href="<?php echo e(route('edit-vehicle', ['id' => $vehicle->id])); ?>"
                                   target="_blank"
                                   class="mr-5 text-sm text-gray-600 cursor-pointer hover:underline"><?php echo e(__('buttons.edit')); ?></a>

                                <?php if($vehicle->trashed()): ?>
                                    <p class="restore-vehicle-button text-sm text-gray-600 cursor-pointer hover:underline"><?php echo e(__('short-phrases.restore')); ?></p>
                                <?php else: ?>
                                    <p class="delete-vehicle-button text-sm text-gray-600 cursor-pointer hover:underline"><?php echo e(__('buttons.delete')); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-span-full lg:col-span-7 flex flex-col px-6 sm:px-8 py-6">
                        <p class="mb-4 text-2xl text-black font-medium"><?php echo e($vehicle->brand); ?>&nbsp;<span class="text-gray-600"><?php echo e($vehicle->model); ?></span></p>
                        <div class="flex flex-wrap mb-auto">
                            <?php $__currentLoopData = $vehicle->params; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $param): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p class="mr-5 last:mr-0 mb-3 text-sm text-gray-600"><?php echo e($param->getLocaleName()); ?>:&nbsp;<span class="text-black font-semibold"><?php echo e($param->pivot[app()->getLocale() . '_value']); ?></span></p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end mt-5">
                            <p class="mb-2 sm:mb-0 text-xl text-black font-medium">$ <?php echo e($vehicle->cost); ?>&nbsp;<span class="text-gray-600">/ <?php echo e(__('short-phrases.day')); ?></span></p>
                            <div class="show-vehicle-order-button px-16 py-2 text-white text-center text-semibold bg-black rounded cursor-pointer"><?php echo e(__('short-phrases.order')); ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p><?php echo e(__('short-phrases.empty-list')); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <?php echo $__env->make('components.general.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Popups -->
    <?php echo $__env->make('popups.login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('popups.reg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('popups.vehicle-order', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Widgets -->
    <?php echo $__env->make('widgets.click-to-call', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH /Users/butingeorgiy/Workspace/Dev/www-root/alitasin/resources/views/vehicles.blade.php ENDPATH**/ ?>