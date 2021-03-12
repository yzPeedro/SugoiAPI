<?php

stream_context_set_default( [
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
]);

ini_set('max_execution_time', '50');
set_time_limit(45);
