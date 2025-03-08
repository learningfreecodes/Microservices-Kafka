<?php

namespace Tests\Feature;


use App\Models\Product;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_and_manage_products():void
    {
        $numberOfProducts = 5;

        for ($i = 1; $i <= $numberOfProducts; $i++) {
            // Create
            $productData = ProductFactory::new()->create()->toArray();
            $this->assertDatabaseHas('products', $productData);

            $createdProduct = Product::find($productData['id']);

            // Read
            $this->getAndAssertProduct($createdProduct->id, $createdProduct->toArray());

            // Update
            $updatedData = ProductFactory::new()->raw(); // Create new random data
            $this->putAndAssertProduct($createdProduct->id, $updatedData);

            // Delete
            $this->deleteAndAssertProduct($createdProduct->id);
        }
    }

    private function getAndAssertProduct($productId, $expectedData):void
    {
        $response = $this->get("/products/{$productId}");

        $response->assertStatus(200);
        $response->assertJson($expectedData);
    }

    private function putAndAssertProduct($productId, $updatedData):void
    {
        $response = $this->put("/products/{$productId}", $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('products', $updatedData);
    }

    private function deleteAndAssertProduct($productId):void
    {
        $response = $this->delete("/products/{$productId}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('products', ['id' => $productId]);
    }

}
