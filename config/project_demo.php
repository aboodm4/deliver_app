<?php

return [
    /*
    |--------------------------------------------------------------------------
    | ACID rollback demonstration
    |--------------------------------------------------------------------------
    | يجب أن تبقى false في production.
    */
    'enable_acid_failure_demo' => env(
        'ENABLE_ACID_FAILURE_DEMO',
        false
    ),
];
