<?php

$anime = explode("/", $_GET['url'])[1];

$this->get("/anime/$anime", "ApiController@mostrar_anime", $anime);