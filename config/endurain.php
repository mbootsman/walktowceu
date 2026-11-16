<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Endurain base URL
    |--------------------------------------------------------------------------
    |
    | The address of the self-hosted Endurain instance. Activity links
    | entered in the control panel must start with this URL. Stored
    | without a trailing slash.
    |
    */

    'url' => rtrim((string) env('ENDURAIN_URL', ''), '/'),

];
