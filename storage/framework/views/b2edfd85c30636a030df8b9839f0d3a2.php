

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Roles</h2>
    <a href="<?php echo e(route('roles.create')); ?>" class="btn btn-primary">Add Role</a>
    <table class="table mt-3">
        <tr><th>Name</th><th>Actions</th></tr>
        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($role->name); ?></td>
            <td>
                <a href="<?php echo e(route('roles.edit', $role->id)); ?>" class="btn btn-warning btn-sm">Edit</a>
                <form action="<?php echo e(route('roles.destroy', $role->id)); ?>" method="POST" style="display:inline;">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Youcode\Herd\hrsm\resources\views/roles/index.blade.php ENDPATH**/ ?>