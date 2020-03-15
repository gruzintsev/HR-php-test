<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderUpdateRequest;
use App\Models\Order;
use App\Models\Partner;
use App\Services\OrderService;
use Illuminate\Http\Response;

/**
 * Class OrderController.
 */
class OrderController
{
    /** @var OrderService */
    private $service;

    /**
     * OrderController constructor.
     * @param OrderService $service
     */
    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $expiredOrders = $this->service->getExpired();
        $currentOrders = $this->service->getCurrent();
        $newOrders = $this->service->getNew();
        $completedOrders = $this->service->getCompleted();

        return view('orders.index')
            ->with(compact('expiredOrders', 'currentOrders', 'newOrders', 'completedOrders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     * @return Response
     */
    public function edit(Order $order)
    {
        $statuses = Order::statuses();
        $partners = Partner::all();

        return view('orders.edit')
            ->with(compact('order', 'partners', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrderUpdateRequest $request
     * @param Order $order
     * @return Response
     */
    public function update(OrderUpdateRequest $request, Order $order)
    {
        $order->update($request->validated());

        return back()
            ->with(['status' => 'success', 'message' => 'Order successfully updated!']);
    }
}