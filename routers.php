<?php

use App\Router;
use App\Response;

define("BASE", "/");

Router::request(
    ["GET", "POST"], 
    BASE . "", 
    function(Response $response)
    {
        return $response->json([
            "status" => "Success",
            "message" => "O serviço dessa API está operante"
        ])->run();
    }
);

Router::request(
    ["GET", "POST"], 
    BASE . "episode/{episode}/{anime}", 
    [\App\Controller\ApiController::class => "getEpisode"]
);

Router::erro404(function(Response $response){
    return $response->setStatusCode(404)->json([
        "status" => 404,
        "error" => "Not Found"
    ])->run();
});