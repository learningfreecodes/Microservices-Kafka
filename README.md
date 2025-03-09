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
`id_product` означает идентификатор товара в БД проекта
`id_shopify` означает идентификатор товара во внешнем API Shopify
`all` это данные полученные из внешнего API Shopify

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

### Job `ProductIntegrationJob`
Берётся идентификатор товара и для него ищется соответствие в Базе Данных в таблице `shopify_product`. Если запись с идентификатором продукта найдена, обновляется продукт во внешнем API Shopify через вызов метода `updateProductShopify` в контроллере `ShopifyController`. Если записи нет, то вызывается `createProductShopify` в контроллере `ShopifyController`. После получения ответа с внешнего API создается или обновляется запись в таблице `shopify_product`




## Папка-подпроект `api-product`
Имеется внутренняя База Данных и таблица `shopify_product`
Маршруты тут такие
```PHP
Route::post('/getToken', [KeycloakController::class, 'index']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::controller(ProductController::class)->group(function () {
        Route::post('/products', 'store');
        Route::get('/products', 'index');
        Route::get('/products/{id}', 'show');
        Route::put('/products/{id}',  'update');
        Route::delete('/products/{id}',  'destroy');
    });
});
```
### Контроллер `ProductController`. 
Он реализует REST API

### Контроллер `KeycloakController` 
Делает внешний запрос к внешнему API

### Обсервер `ProductObserver`
Он наблюдает за моделью Product. В случае создания товара он публикует сообщение в Kafka в топик `'product-created'`
```PHP
Kafka::publishOn('product-created')
        ->withMessage($message)
        ->send();
```
Тип header `headers: ['product' => 'created']`. Тело сообщений в виде массива

В случае обновления товара он публикует сообщение в Kafka в топик `'product-updated'`
```PHP
Kafka::publishOn('product-updated')
        ->withKafkaKey('')        
        ->withMessage($message)
        ->send();
```
Тип header `headers: ['product' => 'updated']`. Тело сообщений в виде массива

При удалении товара создается новая задача в очереди `Job` c прикрепленными данными Product в виде массива
```PHP
ProductIntegrationJob::dispatch($dataToSend)->onQueue('integration_queue');
```