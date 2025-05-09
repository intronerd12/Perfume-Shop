<!DOCTYPE html>
<html>
<head>
    <title>Order Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .receipt { padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .details { margin-bottom: 20px; }
        .items { width: 100%; border-collapse: collapse; }
        .items th, .items td { border: 1px solid #ddd; padding: 8px; }
        .total { margin-top: 20px; text-align: right; }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h1>Order Receipt</h1>
            <p>Order #{{ $order->order_number }}</p>
        </div>

        <div class="details">
            <h3>Customer Details</h3>
            <p>Name: {{ $order->user->name }}</p>
            <p>Email: {{ $order->user->email }}</p>
            <p>Address: {{ $order->shipping_address }}</p>
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->order_items as $item)
                <tr>
                    <td>{{ $item->product->title }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ $item->price }}</td>
                    <td>${{ $item->quantity * $item->price }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            <p>Subtotal: ${{ $order->sub_total }}</p>
            <p>Shipping: ${{ $order->shipping_charge }}</p>
            <h3>Total: ${{ $order->total_amount }}</h3>
        </div>
    </div>
</body>
</html>
