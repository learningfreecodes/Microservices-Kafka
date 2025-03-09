# Описание проекта
В проекте имеется внутренняя БД с 

## Папка-подпроект `api-integration`
Имеется внутренняя База Данных и таблица `shopify_product`

```PHP
      Schema::create('shopify_product', function (Blueprint $table) {
            $table->bigInteger('id_product')->nullable(false);
            $table->bigInteger('id_shopify')->nullable(false);
            $table->json('all')->nullable();
            $table->timestamps();
            $table->unique(['id_product', 'id_shopify']);
        });
```

Ещё имеется внешний API `Shopify`, который управляется через обёртку `Http::shopify()`.

Использована библиотека `mateusjunges/laravel-kafka` для Kafka и `shopify/shopify-api` для Shopify.
Данный проект устроен особым образом. В контроллере описаны статические методы `public static function updateProductShopify($product): array` и `public static function createProductShopify($product): array`. Они вызываются из команды `ProductCreateTopicConsumer`, которая подписывается на события Kafka.

### Устройство контроллера `ShopifyController`
- Статический метод `updateProductShopify`. В нём происходит обращение к внешнему API для создания товаров. `$response = Http::shopify()->post("/products/".$product['id_shopify'], [` - обращение к API происходит так. 
- Статический метод `createProductShopify`. В нём происходит обращение к внешнему API для создания товаров. `$response = Http::shopify()->post('/products.json', [` - обращение к API происходит так. 

### Команда `ProductCreateTopicConsumer`
Подписка на события так 
```PHP
$consumer = Kafka::createConsumer(['product'])
// ->withBrokers('localhost:8092')
->withAutoCommit()
->withHandler(function(KafkaConsumerMessage $message) {
```
Когда сообщение появляется, вызываются статические методы контроллера `ShopifyController` в зависимости от того создан ли объект в Shopify или не создан, происходит вызов API создания или обновления данных товара.

### Контроллер `ShopifyProductController.php` реализовывает REST API редактирования товаров.

### Маршруты
- REST API
```PHP 
Route::controller(ShopifyProductController::class)->group(function () {
    Route::post('/products', 'store');
    Route::get('/products', 'index');
    Route::get('/products/{id}', 'show');
    Route::put('/products/{id}', 'update');
    Route::delete('/products/{id}', 'destroy');
});
```
- Имеется редирект на внешний API в роутах для получения информации о товарах
```PHP
Route::get('/shopify/products', function () {
    $products = Http::shopify()->get('/products.json');
    return response($products);
});
```
