<?php

namespace App\Services;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Class OrderService
 * @package App\Services
 */
class OrderService
{
    /**
     * @return Collection
     */
    public function getExpired(): Collection
    {
        $orders = Order::with('partner', 'products')
            ->where('delivery_dt', '<', Carbon::now())
            ->where('status', '=', Order::STATUS_CONFIRMED)
            ->orderByDesc('delivery_dt')
            ->limit(config('limits.orders.expired'))
            ->get();

        return $orders;
    }

    /**
     * @return Collection
     */
    public function getCurrent(): Collection
    {
        $orders = Order::with('partner', 'products')
            ->where('delivery_dt', '>', Carbon::now()->addDay())
            ->where('status', '=', Order::STATUS_CONFIRMED)
            ->orderBy('delivery_dt')
            ->get();

        return $orders;
    }

    /**
     * @return Collection
     */
    public function getNew(): Collection
    {
        $orders = Order::with('partner', 'products')
            ->where('delivery_dt', '>', Carbon::now())
            ->where('status', '=', Order::STATUS_NEW)
            ->orderBy('delivery_dt')
            ->limit(config('limits.orders.new'))
            ->get();

        return $orders;
    }

    /**
     * @return Collection
     */
    public function getCompleted(): Collection
    {
        $orders = Order::with('partner', 'products')
            ->whereBetween('delivery_dt', [Carbon::today(), Carbon::tomorrow()])
            ->where('status', '=', Order::STATUS_COMPLETED)
            ->orderByDesc('delivery_dt')
            ->limit(config('limits.orders.completed'))
            ->get();

        return $orders;
    }

}