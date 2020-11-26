<?php
require "ApiController.php";

use Api\AnimesController;
$app = new AnimesController();
if ( isset($_GET['url']) && !empty($_GET['url']) ) {
    $url = explode("/", $_GET['url']);
    $anime = (isset($url[3])) ? $url[3] : "";
    $episode = (isset($url[4])) ? $url[4] : "";
    if ( $url[0] == "pphoenix" && $url[1] == "api" ) {
        if ( isset($url[2]) ) {
            if ( $url[2] == "get_episode" && isset($url[3]) && isset($url[4]) ) {
                print_r($app->getEpisode($url[3], $url[4]));
            } elseif ( $url[2] == "verify_if_anime_exists" && isset($url[3]) && !isset($url[4])) {
                print_r($app->verifyIfAnimeExists($url[3]));
            } elseif ( $url[2] == "verify_if_exists_all_episodes" && isset($url[3]) && isset($url[4]) ) {
                print_r($app->verifyIfExistsAllEpisodes($url[3], $url[4]));
            } elseif( $url[2] == "count_episodes" && isset($url[3]) && !isset($url[4])) {
                print_r($app->countEpisodes($url[3]));
            } else if( $url[2] == "search_anime" && isset($url[3]) && !isset($url[4]) ) {
                print_r($app->searchAnime($url[3]));
            } else {
                print_r(json_encode(["error" => "Bad Request", "status" => "HTTP/1.1 400"]));
                http_response_code(400);    
            }
        } else {
            print_r(json_encode(["error" => "Bad Request", "status" => "HTTP/1.1 400"]));
            http_response_code(400);
        }
    } else {
        print_r(json_encode(["error" => "Not Found", "status" => "HTTP/1.1 404"]));
        http_response_code(404);
    }
} else {
    print_r(json_encode(["error" => "Not Found", "status" => "HTTP/1.1 404"]));
    http_response_code(404);
}