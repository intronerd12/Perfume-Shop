<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Thank you for your purchase!</h1>
    <h2>Order Details</h2>
    
    <table>
        <tr>
            <th>Order Number:</th>
            <td><?php echo e($order->order_number); ?></td>
        </tr>
        <tr>
            <th>Subtotal:</th>
            <td>₱<?php echo e(number_format($order->sub_total,2)); ?></td>
        </tr>
        <?php if($order->coupon): ?>
        <tr>
            <th>Discount:</th>
            <td>-₱<?php echo e(number_format($order->coupon->value,2)); ?></td>
        </tr>
        <?php endif; ?>
        <tr>
            <th>Total Amount:</th>
            <td>₱<?php echo e(number_format($order->total_amount,2)); ?></td>
        </tr>
    </table>

    <h3>Shipping Details</h3>
    <p><?php echo e($order->first_name); ?> <?php echo e($order->last_name); ?><br>
    <?php echo e($order->address1); ?><br>
    <?php echo e($order->address2); ?><br>
    <?php echo e($order->phone); ?></p>
</body>
</html>
<?php /**PATH C:\xampp_bumatay\htdocs\Perfume-Shop-main\resources\views/mail/order-confirmation.blade.php ENDPATH**/ ?>