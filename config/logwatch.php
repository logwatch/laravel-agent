<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication token
    |--------------------------------------------------------------------------
    |
    | Your authentication token is required to use Logwatch, and with out it,
    | you won't be able to send logs. You can generate auth tokens for each
    | of your environments in the dashboard.
    |
    */
    'auth_token' => env('LOGWATCH_TOKEN', 'changeme'),

    /*
    |--------------------------------------------------------------------------
    | Minimum logging level
    |--------------------------------------------------------------------------
    |
    | Here you can specify the minimum log level that you would like to send
    | to Logwatch. The possible values are:
    | debug, info, notice, warning, error, critical, alert, emergency.
    |
    */
    'min_level' => env('LOGWATCH_MIN_LEVEL', 'debug'),

    'endpoints' => [

        /*
        |--------------------------------------------------------------------------
        | Logging submission endpoint
        |--------------------------------------------------------------------------
        |
        | This controls the URL that log payloads are sent to. You wouldn't normally
        | have a reason to change this value.
        |
        */
        'logging' => env('LOGWATCH_LOGGING_ENDPOINT', 'https://logs.logwatch.io'),

        /*
        |--------------------------------------------------------------------------
        | Monitoring submission endpoint
        |--------------------------------------------------------------------------
        |
        | This controls the URL that monitoring payloads are sent to. You wouldn't
        | normally have a reason to change this value.
        |
        */
        'monitoring' => env('LOGWATCH_MONITORING_ENDPOINT', 'https://monitoring.logwatch.io'),

    ],

];
