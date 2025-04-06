<!DOCTYPE html>
<html>
<head>
    <title>Order Status Update</title>
</head>
<body>
    <h2>Order Status Update</h2>
    <p>Dear {{$order->first_name}},</p>
    
    <p>Your order #{{$order->order_number}} status has been updated to: <strong>{{strtoupper($order->status)}}</strong></p>
    
    <h3>Order Summary:</h3>
    <ul>
        <li>Order Total: ₱{{number_format($order->total_amount,2)}}</li>
        <li>Payment Method: {{$order->payment_method}}</li>
        <li>Order Date: {{$order->created_at->format('M d, Y')}}</li>
    </ul>

    <p>If you have any questions, please contact us.</p>
    
    <p>Thank you for shopping with us!</p>
</body>
</html>
