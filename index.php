<?php
require "ApiController.php";

use Api\AnimesController;

$app = new AnimesController();
print_r($app->getEpisode('Satsuriku no Tenshi', '1'));