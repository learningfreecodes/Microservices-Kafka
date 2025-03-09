<?php

namespace App\Console\Commands;

use App\Http\Controllers\ShopifyController;
use App\Models\ShopifyProduct;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Contracts\KafkaConsumerMessage;

/**
 * В команде реализована подписка на события Kafka
 */
class ProductCreateTopicConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:product-topic-consumer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Consume Kafka messages from 'products'.";

    /**
     * Execute the console command.
     */
    public function handle()
    {

        //Создается консумер
        $consumer = Kafka::createConsumer(['product'])
            // ->withBrokers('localhost:8092')
            ->withAutoCommit()
            ->withHandler(function(KafkaConsumerMessage $message) {
                // Управление сообщениями происходит здесь:

                $product = $message->getBody(); //Получает товары из Kafka
                Log::info('Produto:');
                Log::debug($product);
                Log::info('------');

                // $product = $this->data;
                //находит соотвтествие идентификатора с идентификатором в БД
                $id_shopify = ShopifyProduct::whereIdProduct($product['id'])->value("id_shopify");
                if ($id_shopify > 0) {
                    $product['id_shopify'] = $id_shopify;
                    Log::info('Found on database updating on shopify', $product);
                    $response = ShopifyController::updateProductShopify($product);
                } else {
                    Log::info('Not Found on database is a insert on shopify', $product);
                    $response = ShopifyController::createProductShopify($product);
                }
                Log::info('Return from shopify statusCode: '.$response['statusCode'], $response);
                if ($response['statusCode'] !== "400") {
                    $insertArray = [
                        'id_product' => $product['id'],
                        'id_shopify' => $response['body']['product']['id'],
                        'all' => json_encode($response['body']['product'])
                    ];
                    log::info('Array a ser inserido produto:'.$product['id'], $insertArray);

                    log::info("teste", $insertArray);
                    ShopifyProduct::create($insertArray);
                    return;
        //            $insertStatus = ShopifyProduct::create($arrayCreate);
        //            log::info("INSERT?????", ['data' => $data]);
                }

            })
            ->build();

        $consumer->consume();


        //
    }
}
