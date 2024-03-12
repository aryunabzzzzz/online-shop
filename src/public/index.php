<?php
Use Core\Autoloader;
Use Core\App;

require_once "./../Core/Autoloader.php";

$autoloader = new Autoloader();
$autoloader->registrate();

$app = new App();
$app->run();