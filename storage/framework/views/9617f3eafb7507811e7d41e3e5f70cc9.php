

<?php $__env->startSection('content'); ?>
<h2>Employee Progress</h2>
<ul>
    <?php $__currentLoopData = $progress; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li>
        <!-- Check if employee exists before accessing the name -->
        <?php echo e($event->employee ? $event->employee->name : 'No Employee'); ?> - 
        <?php echo e($event->type); ?>: <?php echo e($event->description); ?> (<?php echo e($event->date); ?>)
    </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Youcode\Herd\hrsm\resources\views/progress/index.blade.php ENDPATH**/ ?>