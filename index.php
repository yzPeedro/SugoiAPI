<?php
require "ApiController.php";

use Api\AnimesController;

$app = new AnimesController();
print_r($app->verifyIfExistsAllEpisodes('noragami', '12'));