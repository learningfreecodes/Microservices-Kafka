<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shopify_product', function (Blueprint $table) {
            $table->bigInteger('id_product')->nullable(false);
            $table->bigInteger('id_shopify')->nullable(false);
            $table->json('all')->nullable();
            $table->timestamps();
            $table->unique(['id_product', 'id_shopify']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shopify_product');
    }
};
