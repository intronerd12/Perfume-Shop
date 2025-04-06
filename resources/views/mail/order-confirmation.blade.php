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
            <td>{{$order->order_number}}</td>
        </tr>
        <tr>
            <th>Subtotal:</th>
            <td>₱{{number_format($order->sub_total,2)}}</td>
        </tr>
        @if($order->coupon)
        <tr>
            <th>Discount:</th>
            <td>-₱{{number_format($order->coupon->value,2)}}</td>
        </tr>
        @endif
        <tr>
            <th>Total Amount:</th>
            <td>₱{{number_format($order->total_amount,2)}}</td>
        </tr>
    </table>

    <h3>Shipping Details</h3>
    <p>{{$order->first_name}} {{$order->last_name}}<br>
    {{$order->address1}}<br>
    {{$order->address2}}<br>
    {{$order->phone}}</p>
</body>
</html>
