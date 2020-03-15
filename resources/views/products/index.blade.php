@extends('layouts.main')

@section('title', 'Products')

@section('scripts')
    <script src="{{ asset('js/script.js') }}"></script>
@endsection

@section('content')
    <div class="products-list table-responsive">

        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Product ID</th>
                <th scope="col">Name</th>
                <th scope="col">Vendor</th>
                <th scope="col">Price</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr class="product" id="product-{{ $product->id }}">
                    <th>{{ $product->id }}</th>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->vendor->name }}</td>
                    <td class="product-price" data-id="{{ $product->id }}" data-price="{{ $product->price }}">
                        <form class="product-price-form form-inline hidden" method="POST"
                              action="{{ route('products.change-price', $product->id) }}">
                            {{ csrf_field() }}
                            <input name="id" type="hidden" value="{{ $product->id }}">
                            <input name="price" type="number" min="1" step="1" value="{{ $product->price }}">
                            <button type="submit">Save</button>
                        </form>
                        <a href="javascript:void(0)" class="product-price-value">{{ $product->price }}</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $products->links() }}
    </div>
@endsection