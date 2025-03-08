<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $page = Product::query()->paginate();
        return response()->json(compact('page'));
    }

    /**
     * Create Product.
     *
     * @param CreateProductRequest $request
     * @return JsonResponse
     */
    public function store(CreateProductRequest $request)
    {
        $item = new Product;
        $item->fill($request->validated());
        $item->save();
        return response()->json(compact('item'));
    }

    /**
     * Get Product
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $item = Product::query()->findOrFail($id);
        return response()->json(compact('item'));
    }

    /**
     * Update Product
     *
     * @param  int  $id
     * @param UpdateProductRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateProductRequest $request)
    {
        $item = Product::query()->findOrFail($id);
        $item->update($request->validated());
        return response()->json(compact('item'));
    }

    /**
     * Delete Product
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return response()->json('Error', 400);
    }
}
