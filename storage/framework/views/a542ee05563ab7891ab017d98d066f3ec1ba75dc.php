<!doctype html>
<html lang='<?php echo e(App::getLocale()); ?>'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport'
          content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <script type='text/javascript' src='<?php echo e(asset('js/index.js')); ?>'></script>
    <link rel='stylesheet' href='<?php echo e(asset('css/index.css')); ?>'>
    <link rel="icon" href="<?php echo e(asset('images/favicon.ico')); ?>">
    <title><?php echo e(__('page-titles.main')); ?></title>
</head>
<body>
    <?php echo $__env->make('components.general.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.general.hero', ['title' => __('short-phrases.tours-in-turkey')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.index.global-search', ['bottomBorder' => false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.index.main-sections', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.index.regions', ['title' => __('short-phrases.choose-your-region'), 'bottomBorder' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.general.tours', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.index.transport', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.general.reviews-slider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.general.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Popups -->
    <?php echo $__env->make('popups.login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('popups.reg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Widgets -->
    <?php echo $__env->make('widgets.click-to-call', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH /Users/butingeorgiy/Workspace/Dev/www-root/alitasin/resources/views/index.blade.php ENDPATH**/ ?>