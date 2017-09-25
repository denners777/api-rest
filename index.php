<?php

require './vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

require './src/bootstrap.php';

require './src/routes.php';

$app->run();
