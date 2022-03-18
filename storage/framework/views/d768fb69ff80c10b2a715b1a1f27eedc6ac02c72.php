<section id="regionsSection" class="mb-10 <?php echo e($bottomBorder ? 'pb-6 border-b border-gray-200' : ''); ?>">
    <div class="container mx-auto px-5">
        <p class="mb-2 sm:mb-4 lg:text-center text-black text-2xl font-bold text-black"><?php echo e($title); ?><span class="text-blue">.</span></p>
        <div class="hidden sm:grid grid-cols-2 lg:grid-cols-3 gap-4">
            <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('region', $region->id)); ?>" class="region-card relative top-0 flex justify-center items-center text-white text-3xl
                   font-bold tracking-wide bg-center bg-cover bg-no-repeat rounded-md duration-300 hover:shadow-xl"
                   style="height: 180px; background-image: url(<?php echo e($region->image); ?>)">
                    <?php echo e($region->name); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="block sm:hidden swiper-container -mx-3">
            <div class="swiper-wrapper -mx-2 px-5 py-2">
                <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('region', $region->id)); ?>" class="swiper-slide relative flex justify-center items-center w-72 text-white text-3xl font-bold tracking-wide bg-center bg-cover bg-no-repeat rounded-md"
                       style="height: 180px; background-image: url(<?php echo e($region->image); ?>)">
                        <?php echo e($region->name); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</section>
<?php /**PATH /Users/butingeorgiy/Workspace/Dev/www-root/alitasin/resources/views/components/index/regions.blade.php ENDPATH**/ ?>