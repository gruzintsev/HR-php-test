@extends('layouts.main')

@section('title', 'Orders')

@section('content')
    <div>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#expired">Expired</a></li>
            <li><a data-toggle="tab" href="#current">Current</a></li>
            <li><a data-toggle="tab" href="#new">New</a></li>
            <li><a data-toggle="tab" href="#complete">Completed</a></li>
        </ul>

        <div class="tab-content">
            <div id="expired" class="tab-pane fade in active">
                <h3>Expired</h3>
                @include('orders.components.table', ['orders' => $expiredOrders])
            </div>
            <div id="current" class="tab-pane fade">
                <h3>Текущие</h3>
                @include('orders.components.table', ['orders' => $currentOrders])
            </div>
            <div id="new" class="tab-pane fade">
                <h3>Новые</h3>
                @include('orders.components.table', ['orders' => $newOrders])
            </div>
            <div id="complete" class="tab-pane fade">
                <h3>Выполненные</h3>
                @include('orders.components.table', ['orders' => $completedOrders])
            </div>
        </div>
    </div>
@endsection