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
    <title><?php echo e(__('page-titles.property')); ?></title>
</head>
<body>
    <?php echo $__env->make('components.general.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.general.hero', ['title' => __('short-phrases.property'), 'image' => asset('images/main-sections-bg-hotels.jpg')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.index.global-search', ['bottomBorder' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <section id="propertyTypesSection" class="mb-4 pb-4 sm:pb-6">
        <div class="container mx-auto px-5">
            

            <div class="flex flex-col sm:flex-row sm:items-center text-xl">
                <div class="flex mb-5 sm:mb-0">
                    <span class="font-semibold"><?php echo e(__('short-phrases.choose-region')); ?>:&nbsp;&nbsp;</span>
                    <select class="placeholder-gray-800 text-blue bg-white font-semibold cursor-pointer"
                            name="region_id">
                        <option value=""><?php echo e(__('short-phrases.any')); ?></option>
                        <?php $__currentLoopData = App\Models\Region::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($region->id); ?>" <?php echo e((string) $region->id === request()->input('region_id', '') ? 'selected' : ''); ?>>
                                <?php echo e($region->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="flex">
                    <span class="font-semibold"><?php echo e(__('short-phrases.choose-type')); ?>:&nbsp;&nbsp;</span>
                    <select class="placeholder-gray-800 text-blue bg-white font-semibold cursor-pointer"
                            name="type_id">
                        <option value=""><?php echo e(__('short-phrases.any')); ?></option>
                        <?php $__currentLoopData = App\Models\PropertyType::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type->id); ?>" <?php echo e((string) $type->id === request()->input('type_id', '') ? 'selected' : ''); ?>>
                                <?php echo e($type->getLocaleName()); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <section id="propertySection" class="pb-10">
        <div class="container flex flex-col mx-auto px-5">
            <?php /** @var App\Models\Property $property */ ?>
            <?php $__empty_1 = true; $__currentLoopData = $propertyItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="property-item grid grid-cols-12 mb-5 last:mb-0 bg-gray-1200 rounded-md shadow"
                     data-id="<?php echo e($property->id); ?>"
                     data-title="<?php echo e($property->getLocaleTitle()); ?>">
                    <div class="col-span-full lg:col-span-5 relative flex flex-col items-center px-8 sm:px-16 pt-8 sm:pt-12 lg:pb-12 lg:border-r border-gray-1300">
                        <div class="show-property-gallery-btn w-full h-44 bg-contain bg-center bg-no-repeat cursor-pointer"
                             data-images="<?php echo e(json_encode($property->getAllImagesUrl())); ?>"
                             style="background-image: url(<?php echo e($property->getPreviewImage()); ?>)">
                            <svg class="absolute min-h-6 min-w-6 h-6 w-6 bottom-5 right-5 text-blue"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0
                                  0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                            </svg>
                        </div>
                        <?php if(App\Facades\Auth::check(['5'])): ?>
                            <div class="flex absolute bottom-4">
                                <a href="<?php echo e(route('edit-property', ['id' => $property->id])); ?>"
                                   target="_blank"
                                   class="mr-5 text-sm text-gray-600 cursor-pointer hover:underline"><?php echo e(__('buttons.edit')); ?></a>

                                <?php if($property->trashed()): ?>
                                    <p class="restore-property-button text-sm text-gray-600 cursor-pointer hover:underline"><?php echo e(__('short-phrases.restore')); ?></p>
                                <?php else: ?>
                                    <p class="delete-property-button text-sm text-gray-600 cursor-pointer hover:underline"><?php echo e(__('buttons.delete')); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-span-full lg:col-span-7 flex flex-col px-6 sm:px-8 py-6">
                        <p class="mb-4 text-2xl text-black font-medium"><?php echo e($property->getLocaleTitle()); ?></p>
                        <div class="flex flex-wrap mb-auto">
                            <p class="mr-5 last:mr-0 mb-3 text-sm text-gray-600"><?php echo e(__('short-phrases.region')); ?>:&nbsp;
                                <span class="text-black font-semibold"><?php echo e($property->region->name); ?></span>
                            </p>

                            <p class="mr-5 last:mr-0 mb-3 text-sm text-gray-600"><?php echo e(__('short-phrases.property-type')); ?>:&nbsp;
                                <span class="text-black font-semibold"><?php echo e($property->type->getLocaleName()); ?></span>
                            </p>

                            <?php $__currentLoopData = $property->params; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $param): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p class="mr-5 last:mr-0 mb-3 text-sm text-gray-600"><?php echo e($param->getLocaleName()); ?>:&nbsp;<span
                                            class="text-black font-semibold"><?php echo e($param->pivot[App::getLocale() . '_value']); ?></span>
                                </p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end mt-5">
                            <p class="mb-2 sm:mb-0 text-xl text-black font-medium">
                                $ <?php echo e(number_format($property->cost, 2, '.', ' ')); ?>

                                <?php if($property->unit): ?>
                                    <span class="text-gray-600">/ <?php echo e($property->unit->getLocaleName()); ?></span>
                                <?php endif; ?>
                            </p>
                            <div class="show-property-order-button px-16 py-2 text-white text-center text-semibold bg-black rounded cursor-pointer"><?php echo e(__('short-phrases.order')); ?></div>
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
    <?php echo $__env->make('popups.property-order', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Widgets -->
    <?php echo $__env->make('widgets.click-to-call', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH /Users/butingeorgiy/Workspace/Dev/www-root/alitasin/resources/views/property.blade.php ENDPATH**/ ?>