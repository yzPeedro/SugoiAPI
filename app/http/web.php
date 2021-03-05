<?php

$url = (isset($_GET['url'])) ? explode("/", $_GET['url']) : "";

(isset($url[1])) ? $anime = $url[1] : $anime = "";
(isset($url[2])) ? $episode = $url[2] : $episode = "";


$this->get("/search_anime/$anime", "ApiController@searchAnime", $anime);
$this->get("/count_episodes/$anime/$episode", "ApiController@countEp", [$anime, $episode]);
$this->get("/get_episode/$anime/$episode", "ApiController@getEpisode", [$anime, $episode]);