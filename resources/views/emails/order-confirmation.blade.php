<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <h2>Thank you for your order!</h2>
    <p>Order Number: {{$order->order_number}}</p>
    <p>Total Amount: ₱{{number_format($order->total_amount,2)}}</p>
    <p>Status: {{$order->status}}</p>
    <hr>
    <p>Shipping Details:</p>
    <p>{{$order->first_name}} {{$order->last_name}}</p>
    <p>{{$order->address1}}</p>
    <p>{{$order->phone}}</p>
</body>
</html>
