<?php
require_once('vendor/autoload.php');
require_once("app/configs/functions.php");

ini_set('max_execution_time', '45');
set_time_limit(45);


(new app\http\RouterCore);