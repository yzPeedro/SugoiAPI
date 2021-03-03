<?php

$url = (isset($_GET['url'])) ? explode("/", $_GET['url']) : "";

(isset($url[1])) ? $anime = $url[1] : $anime = "";
(isset($url[2])) ? $quantEp = $url[2] : $quantEp = "";


$this->get("/search_anime/$anime", "ApiController@searchAnime", $anime);
$this->get("/count_episodes/$anime/$quantEp", "ApiController@countEp", [$anime, $quantEp]);