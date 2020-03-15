@php
    /** @var \App\Models\Order $order */
@endphp
<h1>Order #{{ $order->id }} is completed</h1>

<h2>Products</h2>
<table>
    <thead>
    <tr>
        <th>Product</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Cost</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->products as $product)
        <tr>
            <td>{{ $product->product ? $product->product->name : ''}}</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->getTotal() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<h3>Cost: {{ $order->getCost() }}</h3>