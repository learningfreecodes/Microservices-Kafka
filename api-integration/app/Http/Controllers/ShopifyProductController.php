<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShopifyProductResource;
use App\Models\ShopifyProduct;
use Illuminate\Http\Request;

class ShopifyProductController extends Controller
{
    public function index()
    {
        return ShopifyProductResource::collection(ShopifyProduct::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_product' => ['required', 'integer'],
            'id_shopify' => ['required', 'integer'],
            'all' => ['nullable'],
        ]);

        return new ShopifyProductResource(ShopifyProduct::create($data));
    }

    public function show(int $id)
    {
        $data = ShopifyProduct::whereIdProduct($id);
        if ($data) {
            return new ShopifyProductResource($data[0]);
        }
    }

    public function update(Request $request, ShopifyProduct $shopifyProduct)
    {
        $data = $request->validate([
            'id_product' => ['required', 'integer'],
            'id_shopify' => ['required', 'integer'],
            'all' => ['nullable'],
        ]);

        $shopifyProduct->update($data);

        return new ShopifyProductResource($shopifyProduct);
    }

    public function destroy(ShopifyProduct $shopifyProduct)
    {
        $shopifyProduct->delete();

        return response()->json();
    }
}
