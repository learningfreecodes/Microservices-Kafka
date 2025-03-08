<?php

namespace App\Observers;

// use App\Events\ProductCreatedEvent;
// use App\Events\ProductUpdateEvent;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use App\Jobs\ProductIntegrationJob;
use App\Models\Product;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Log;

// use Illuminate\Support\Facades\Queue;

class ProductObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the item "created" event.
     *
     * @param  Product  $product
     * @return void
     */
    public function created(Product $product): void
    {
        $dataToSend = $product->toArray();

        $message = new Message(
            headers: ['product' => 'created'],
            body: $dataToSend
        );
        

        Kafka::publishOn('product-created')
        ->withMessage($message)
        ->send();
        // ->withDebugEnabled(true); // Also to disable debug mode
        // Log::debug(var_dump($return));
        // $producer->send();
    }

    /**
     * Handle the item "updated" event.
     *
     * @param  Product  $product
     * @return void
     */
    public function updated(Product $product): void
    {
        $dataToSend = $product->toArray();
        Log::info($dataToSend);

        $message = new Message(
            headers: ['product' => 'updated'],
            body: $dataToSend
        );
        

        Kafka::publishOn('product-updated')
        ->withKafkaKey('')        
        ->withMessage($message)
        ->send();

        // event(new ProductUpdateEvent($product));

//        ProductIntegrationJob::dispatch($dataToSend)->onQueue('integration_queue');

    }

    /**
     * Handle the item "deleted" event.
     *
     * @param  Product  $product
     * @return void
     */
    public function deleted(Product $product): void
    {
        $dataToSend = $product->toArray();
        ProductIntegrationJob::dispatch($dataToSend)->onQueue('integration_queue');
    }
}
