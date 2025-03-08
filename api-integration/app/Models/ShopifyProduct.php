<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopifyProduct extends Model
{

    protected $table = 'shopify_product';

    protected $fillable = [
        'id_product',
        'id_shopify',
        'all',
    ];

    protected $casts = [
        'all' => 'array',
    ];
}
