<?php

return [
    /*
    |--------------------------------------------------------------------------
    | GeoIP Driver Type
    |--------------------------------------------------------------------------
    |
    | Supported: "ipstack", "ip-api", "maxmind", "telize"
    |
    */
    'driver' => env('GEOIP_DRIVER', 'ip-api'),

    /*
    |--------------------------------------------------------------------------
    | Return random ipaddresses (useful for dev envs)
    |--------------------------------------------------------------------------
    */
    'random' => env('GEOIP_RANDOM', false),

    /*
    |--------------------------------------------------------------------------
    | IPStack Driver
    |--------------------------------------------------------------------------
    */
    'ipstack' => [
        /*
        |--------------------------------------------------------------------------
        | IPStack Access Key
        |--------------------------------------------------------------------------
        |
        | Get your access key here: https://ipstack.com/product
        |
        */
        'key' => env('GEOIP_IPSTACK_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | IP-API Driver
    |--------------------------------------------------------------------------
    */
    'ip-api' => [
        /*
        |--------------------------------------------------------------------------
        | IP-API Pro Service Key
        |--------------------------------------------------------------------------
        |
        | Check out pro here: https://signup.ip-api.com/
        |
        */
        'key' => env('GEOIP_IPAPI_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maxmind Driver
    |--------------------------------------------------------------------------
    */
    'maxmind' => [
        /*
        |--------------------------------------------------------------------------
        | Maxmind Database
        |--------------------------------------------------------------------------
        |
        | Example: app_path().'/database/maxmind/GeoLite2-City.mmdb'
        |
        */
        'database' => base_path().'/'.env('GEOIP_MAXMIND_DATABASE', 'database/geoip/GeoLite2-City.mmdb'),

        /*
        |--------------------------------------------------------------------------
        | Maxmind Web Service Info
        |--------------------------------------------------------------------------
        */
        'user_id' => env('GEOIP_MAXMIND_USER_ID'),
        'license_key' => env('GEOIP_MAXMIND_LICENSE_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Telize Driver
    |--------------------------------------------------------------------------
    */
    'telize' => [
        /*
        |--------------------------------------------------------------------------
        | Telize Service Key
        |--------------------------------------------------------------------------
        |
        | Get your API key here: https://market.mashape.com/fcambus/telize
        |
        */
        'key' => env('GEOIP_TELIZE_KEY'),
        'secure' => env('GEOIP_IPSTACK_SECURE', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Cache Driver
    |--------------------------------------------------------------------------
    |
    | Here you may specify the type of caching that should be used
    | by the package.
    |
    | Options:
    |
    |  all  - All location are cached
    |  some - Cache only the requesting user
    |  none - Disable cached
    |
    */

    'cache' => 'none',

    /*
    |--------------------------------------------------------------------------
    | Cache Tags
    |--------------------------------------------------------------------------
    |
    | Cache tags are not supported when using the file or database cache
    | drivers in Laravel. This is done so that only locations can be cleared.
    |
    */

    'cache_tags' => null,
];
