<?php
require "ApiController.php";

use Api\AnimesController;

$app = new AnimesController();
print_r($app->getEpisode('asd9sau9d0', '9182390'));