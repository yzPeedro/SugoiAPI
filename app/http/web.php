<?php

$url = explode("/", $_GET['url']);
(isset($url[1])) ? $anime = $url[1] : $anime = "";

$this->get("/search_anime/$anime", "ApiController@searchAnime", $anime);