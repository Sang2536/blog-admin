<?php

/*
|--------------------------------------------------------------------------
| Default Cors
|--------------------------------------------------------------------------
|
| This option defines the default log channel that is utilized to write
| messages to your logs. The value provided here should match one of
| the channels present in the list of "channels" configured below.
|
*/

return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'], // hoặc ['http://localhost:5173'] nếu muốn chặt chẽ
    'allowed_headers' => ['*'],
    'supports_credentials' => true,
];

