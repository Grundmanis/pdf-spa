<?php

use Dingo\Api\Routing\Router;

$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group(['namespace' => 'App\Http\Controllers\API'], function(Router $api) {
        $api->resource('pdfs', 'PdfController');
    });
});
