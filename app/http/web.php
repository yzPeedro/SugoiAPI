<?php

$anime = explode("/", $_GET['url'])[1];

$this->get("/search_anime/$anime", "ApiController@searchAnime", $anime);