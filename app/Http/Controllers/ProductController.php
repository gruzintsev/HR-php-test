<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductPriceRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

/**
 * Class ProductController.
 */
class ProductController extends Controller
{
    /** @var ProductService */
    private $service;

    /**
     * ProductController constructor.
     * @param ProductService $service
     */
    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $products = $this->service->getAll();

        return view('products.index')->with(compact('products'));
    }

    /**
     * @param UpdateProductPriceRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function changePrice(UpdateProductPriceRequest $request, Product $product)
    {
        $saved = $this->service->changePrice($product, $request->price);

        return response()->json($saved);
    }
}