<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class ProductService
 * @package App\Services
 */
class ProductService
{
    /**
     * @return LengthAwarePaginator
     */
    public function getAll(): LengthAwarePaginator
    {
        $products = Product::query()
            ->orderBy('name', 'asc')
            ->paginate(config('limits.products'));

        return $products;
    }

    /**
     * @param Product $product
     * @param int $price
     * @return bool
     */
    public function changePrice(Product $product, int $price): bool
    {
        $product->price = $price;
        return $product->save();
    }
}