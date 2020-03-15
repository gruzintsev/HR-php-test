<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="brand-logo" href="#"></a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li @if(Route::currentRouteName() == 'weather')class="active"@endif>
                    <a href="{{ route('weather', 'bryansk') }}">Temperature in Bryansk</a>
                </li>
                <li @if(Route::is('orders.*'))class="active"@endif>
                    <a href="{{ route('orders.index') }}">Orders</a>
                </li>
                <li @if(Route::is('products.*'))class="active"@endif>
                    <a href="{{ route('products.index') }}">Products</a>
                </li>
            </ul>
        </div>
    </div>
</nav>