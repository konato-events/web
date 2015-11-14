<?php
function memcacheConfig(string $provider):array {
    if ($provider == 'localhost') {
        $config = [
            'servers' => [
                ['host' => '127.0.0.1', 'port' => 11211, 'weight' => 100]
            ]
        ];
    } else {
        $url = parse_url(getenv("{$provider}_SERVERS"));
        $config = [
            'persistent_id' => 'laravel',
            'sasl'          => [getenv("{$provider}_USERNAME"), getenv("{$provider}_PASSWORD")],
            'servers'       => [
                ['host' => $url['host'], 'port' => $url['port'], 'weight' => getenv("{$provider}_WEIGHT")],
            ]
        ];
    }

    return array_merge(['driver' => 'memcached'], $config);
}

return [

    /*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the default cache connection that gets used while
    | using this caching library. This connection is used when another is
    | not explicitly specified when executing a given caching function.
    |
    */

    'default' => env('CACHE_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Cache Stores
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the cache "stores" for your application as
    | well as their drivers. You may even define multiple stores for the
    | same cache driver to group types of items stored in your caches.
    |
    */

    'stores' => [

        'apc' => [
            'driver' => 'apc',
        ],

        'array' => [
            'driver' => 'array',
        ],

        'database' => [
            'driver' => 'database',
            'table'  => 'cache',
            'connection' => null,
        ],

        'file' => [
            'driver' => 'file',
            'path'   => storage_path('framework/cache'),
        ],

        'memcached'         => memcacheConfig((getenv('APP_ENV') == 'prod')? 'MEMCACHEDCLOUD' : 'localhost'),
        'memcached_session' => memcacheConfig((getenv('APP_ENV') == 'prod')? 'MEMCACHIER' : 'localhost'),

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Key Prefix
    |--------------------------------------------------------------------------
    |
    | When utilizing a RAM based store such as APC or Memcached, there might
    | be other applications utilizing the same cache. So, we'll specify a
    | value to get prefixed to all our keys so we can avoid collisions.
    |
    */

    'prefix' => 'laravel',

];
