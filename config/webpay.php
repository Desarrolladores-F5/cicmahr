<?php

return [
    'environment'   => env('WEBPAY_ENV', 'integration'),
    'commerce_code' => env('WEBPAY_COMMERCE_CODE', '597055555532'),
    'api_key'       => env('WEBPAY_API_KEY', '579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C'),
    'return_url'    => env('WEBPAY_RETURN_URL', 'http://127.0.0.1:8000/webpay/retorno'),
];