<?php
#
# get config data from uci
#
return [
    'myurl' => env('APP_URL', 'http://10.1.0.1/'), // 'bar' is default if MY_VALUE is missing in .env
];