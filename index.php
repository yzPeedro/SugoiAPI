<?php

define("RAIZ", __DIR__);

try
{
    require_once __DIR__ . "/vendor/autoload.php";
    require_once __DIR__ . "/routers.php";
}
catch (Exception $e)
{
    $response = new App\Response();

    return $response->setStatusCode(500)->json([
        "status" => 500,
        "error" => $e->getMessage()
    ])->run();

}

