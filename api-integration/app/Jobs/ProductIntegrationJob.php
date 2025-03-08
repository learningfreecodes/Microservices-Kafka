<?php

namespace App\Jobs;

use App\Http\Controllers\ShopifyController;
use App\Models\ShopifyProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProductIntegrationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @param  mixed  $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle(): void
    {
        $product = $this->data;
        Log::info($product);
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

    }
}






//
//
//insert into
//  `shopify_product` (
//`id_product`,
//    `id_shopify`,
//    `all`,
//    `updated_at`,
//    `created_at`
//  )
//values
//(
//    40,
//    8964662001976,
//    '\"{\\"id\\":8964662001976,\\"title\\":\\"rem cupiditate eveniet Shoes\\",\\"body_html\\":\\"While the Owl had the dish as its share of the Lizard\'s slate-pencil, and the choking of the country is, you ARE a simpleton.\' Alice did not quite know what you were me?\' \'Well, perhaps your feelings may be different,\' said Alice; \'it\'s laid for a minute or two, looking for it, while the Mouse in.\\",\\"vendor\\":\\"FPInfo\\",\\"product_type\\":\\"cat\\",\\"created_at\\":\\"2024-01-31T06:54:58-05:00\\",\\"handle\\":\\"rem-cupiditate-eveniet-shoes\\",\\"updated_at\\":\\"2024-01-31T06:54:58-05:00\\",\\"published_at\\":null,\\"template_suffix\\":null,\\"published_scope\\":\\"web\\",\\"tags\\":\\"\\",\\"status\\":\\"draft\\",\\"admin_graphql_api_id\\":\\"gid:\\\/\\\/shopify\\\/Product\\\/8964662001976\\",\\"variants\\":[{\\"id\\":47748933255480,\\"product_id\\":8964662001976,\\"title\\":\\"Default Title\\",\\"price\\":\\"529.94\\",\\"sku\\":\\"\\",\\"position\\":1,\\"inventory_policy\\":\\"deny\\",\\"compare_at_price\\":null,\\"fulfillment_service\\":\\"manual\\",\\"inventory_management\\":\\"shopify\\",\\"option1\\":\\"Default Title\\",\\"option2\\":null,\\"option3\\":null,\\"created_at\\":\\"2024-01-31T06:54:58-05:00\\",\\"updated_at\\":\\"2024-01-31T06:54:58-05:00\\",\\"taxable\\":true,\\"barcode\\":null,\\"grams\\":0,\\"image_id\\":null,\\"weight\\":0,\\"weight_unit\\":\\"kg\\",\\"inventory_item_id\\":49793569358136,\\"inventory_quantity\\":7,\\"old_inventory_quantity\\":7,\\"requires_shipping\\":true,\\"admin_graphql_api_id\\":\\"gid:\\\/\\\/shopify\\\/ProductVariant\\\/47748933255480\\"}],\\"options\\":[{\\"id\\":11290244481336,\\"product_id\\":8964662001976,\\"name\\":\\"Title\\",\\"position\\":1,\\"values\\":[\\"Default Title\\"]}],\\"images\\":[{\\"id\\":44465168351544,\\"alt\\":null,\\"position\\":1,\\"product_id\\":8964662001976,\\"created_at\\":\\"2024-01-31T06:54:58-05:00\\",\\"updated_at\\":\\"2024-01-31T06:54:58-05:00\\",\\"admin_graphql_api_id\\":\\"gid:\\\/\\\/shopify\\\/ProductImage\\\/44465168351544\\",\\"width\\":640,\\"height\\":480,\\"src\\":\\"https:\\\/\\\/cdn.shopify.com\\\/s\\\/files\\\/1\\\/0786\\\/6082\\\/9496\\\/products\\\/003322.png?v=1706702098\\",\\"variant_ids\\":[]}],\\"image\\":{\\"id\\":44465168351544,\\"alt\\":null,\\"position\\":1,\\"product_id\\":8964662001976,\\"created_at\\":\\"2024-01-31T06:54:58-05:00\\",\\"updated_at\\":\\"2024-01-31T06:54:58-05:00\\",\\"admin_graphql_api_id\\":\\"gid:\\\/\\\/shopify\\\/ProductImage\\\/44465168351544\\",\\"width\\":640,\\"height\\":480,\\"src\\":\\"https:\\\/\\\/cdn.shopify.com\\\/s\\\/files\\\/1\\\/0786\\\/6082\\\/9496\\\/products\\\/003322.png?v=1706702098\\",\\"variant_ids\\":[]}}\"',
//    '2024-01-31 11:54:58',
//    '2024-01-31 11:54:58'
//)