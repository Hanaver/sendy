# Sendy Laravel
 A service provider for Sendy API in Laravel 8

## Installation
```shell
composer require hanz/sendy-api
```
or append your composer.json with:

```json
{
    "require" : {
        "hanz/sendy-api":  "^0.2.5"
    }
}
```
Add the following settings to the config/app.php

Service provider:

```php
'providers' => [
    // ...
    'SendyApi\SendyServiceProvider::class',
]
```

For the `Sendy::` facade

```php
'aliases' => [
    // ...
    'SendyApi' => 'SendyApi\SendyApi::class',
]
```

## Configuration
```shell
php artisan vendor:publish --provider="SendyApi\SendyServiceProvider"
```

It will create sendy.php within the config directory.

```php
<?php

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
    'api_create' => '/api/campaigns/create.php'
];
```
