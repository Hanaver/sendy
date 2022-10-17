<?php
/**
 * Author Andy
 * Date 2022-09-26
 * Time: 15:13
 */

return [
    'api_key' => env('SENDY_API_KEY', null),
    'api_host' => env('SENDY_API_HOST', null),
    'list_id' => env('SENDY_API_LIST_ID', null),
    'api_get_lists' => '/api/lists/get-lists.php',
    'api_get_brands' => '/api/brands/get-brands.php',
    'api_subscribe' => '/subscribe',
    'api_unsubscribe' => '/unsubscribe',
    'api_delete' => '/api/subscribers/delete.php',
    'api_subscription_status' => '/api/subscribers/subscription-status.php',
    'api_active_subscriber_count' => '/api/subscribers/active-subscriber-count.php',
    'api_create' => '/api/campaigns/create.php',
    'api_campaign_delete' => '/api/campaigns/delete.php'
];
