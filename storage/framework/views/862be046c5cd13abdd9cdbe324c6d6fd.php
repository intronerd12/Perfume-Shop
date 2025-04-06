<?php $__env->startSection('title','Order Detail'); ?>

<?php $__env->startSection('main-content'); ?>
<div class="card">
  <h5 class="card-header">Order Edit</h5>
  <div class="card-body">
    <?php if($order): ?>
      <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
      <?php endif; ?>
      <form action="<?php echo e(route('order.update',$order->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>
        <div class="form-group">
          <label for="status">Status :</label>
          <select name="status" id="status" class="form-control <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
            <option value="">-- Select Status --</option>
            <option value="new" <?php echo e(($order->status=='new')? 'selected' : ''); ?>>New</option>
            <option value="process" <?php echo e(($order->status=='process')? 'selected' : ''); ?>>Process</option>
            <option value="delivered" <?php echo e(($order->status=='delivered')? 'selected' : ''); ?>>Delivered</option>
            <option value="cancel" <?php echo e(($order->status=='cancel')? 'selected' : ''); ?>>Cancel</option>
          </select>
          <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="invalid-feedback" role="alert"><?php echo e($message); ?></span>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          <small class="text-muted">Email notification will be sent to customer after update</small>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    <?php else: ?>
      <div class="alert alert-danger">Order not found</div>
    <?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }

</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp_bumatay\htdocs\Perfume-Shop-main\resources\views/backend/order/edit.blade.php ENDPATH**/ ?>