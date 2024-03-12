<?php
Use Core\Autoloader;
Use Core\App;

require_once "./../Core/App.php";
require_once "./../Core/Autoloader.php";

Autoloader::registrate(dirname(__DIR__));

$app = new App();
$app->run();