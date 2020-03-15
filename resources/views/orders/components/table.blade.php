<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead>
        <tr>
            <th scope="col">Order ID</th>
            <th scope="col">Partner</th>
            <th scope="col">Cost</th>
            <th scope="col">Products</th>
            <th scope="col">Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td><a target="_blank" href="{{ route('orders.edit', ['id' => $order->id]) }}">{{ $order->id }}</a></td>
                <td>{{ $order->partner->name }}</td>
                <td>{{ $order->getCost() }}</td>
                <td>
                    @foreach($order->products as $orderProduct)
                        <p>{{ $orderProduct->product ? $orderProduct->product->name : '' }}</p>
                    @endforeach
                </td>
                <td>{{ $order->status_name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>