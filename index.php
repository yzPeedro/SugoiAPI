<?php
require "ApiController.php";

use Api\AnimesController;

$app = new AnimesController();
print_r($app->verifyIfAnimeExists('naruto classico legendado'));