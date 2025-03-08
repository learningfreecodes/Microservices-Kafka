<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\ShopifyProduct */
class ShopifyProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_product' => $this->id_product,
            'id_shopify' => $this->id_shopify,
            'all' => $this->all,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
