@extends('layouts.main')

@section('title', 'Order #' . $order->id)

@section('content')

    <div class="form-group">
        <a href="{{ route('orders.index') }}">Orders</a>
    </div>

        <form method="POST" action="{{ route('orders.update', [$order->id]) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('client_email') ? 'has-error' : '' }}">
                        <label for="email">Email</label>
                        <input name="client_email" type="email" class="form-control" id="email" placeholder="Enter email"
                               value="{{ old('client_email') ?? $order->client_email }}" required>
                        <input name="id" type="hidden" value="{{ $order->id }}" required>
                        @if ($errors->has('client_email'))
                            <span class="help-block">{{ $errors->first('client_email') }}</span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('partner_id') ? 'has-error' : '' }}">
                        <label for="partner">Partner</label>
                        <select name="partner_id" class="form-control" id="partner">
                            @foreach($partners as $partner)
                                <option value="{{ $partner->id }}" {{ $partner->id == $order->partner_id ? 'selected' : '' }}>
                                    {{ $partner->name }} ({{ $partner->email }})
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('partner_id'))
                            <span class="help-block">{{ $errors->first('partner_id') }}</span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        <label for="partner">Status</label>
                        <select name="status" class="form-control" id="status">
                            @foreach($statuses as $key => $status)
                                <option value="{{ $key }}" {{ $key == $order->status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('status'))
                            <span class="help-block">{{ $errors->first('status') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">Products</div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-right">Quantity</th>
                                <th class="text-right">Price</th>
                                <th class="text-right">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($totalSum = 0)
                            @foreach($order->products as $orderProduct)
                                @php($productCost = $orderProduct->getTotal())
                                <tr>
                                    <td>{{ $orderProduct->product ? $orderProduct->product->name : '' }}</td>
                                    <td class="text-right">{{ $orderProduct->quantity }}</td>
                                    <td class="text-right">{{ $orderProduct->price }}</td>
                                    <td class="text-right">{{ $orderProduct->quantity * $orderProduct->price }}</td>
                                </tr>
                                @php($totalSum += $productCost)
                            @endforeach
                                <tr>
                                    <td colspan="4" class="text-right">{{ $totalSum }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
@endsection