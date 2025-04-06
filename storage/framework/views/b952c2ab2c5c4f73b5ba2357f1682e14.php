<!DOCTYPE html>
<html>
<head>
    <title>Order Status Update</title>
</head>
<body>
    <h2>Order Status Update</h2>
    <p>Dear <?php echo e($order->first_name); ?>,</p>
    
    <p>Your order #<?php echo e($order->order_number); ?> status has been updated to: <strong><?php echo e(strtoupper($order->status)); ?></strong></p>
    
    <h3>Order Summary:</h3>
    <ul>
        <li>Order Total: ₱<?php echo e(number_format($order->total_amount,2)); ?></li>
        <li>Payment Method: <?php echo e($order->payment_method); ?></li>
        <li>Order Date: <?php echo e($order->created_at->format('M d, Y')); ?></li>
    </ul>

    <p>If you have any questions, please contact us.</p>
    
    <p>Thank you for shopping with us!</p>
</body>
</html>
<?php /**PATH C:\xampp_bumatay\htdocs\Perfume-Shop-main\resources\views/emails/order-status.blade.php ENDPATH**/ ?>