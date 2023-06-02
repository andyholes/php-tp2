<?php

require '../vendor/autoload.php'; // Carga las dependencias de Slim PHP

use Slim\Factory\AppFactory;

require 'model/Db.php';
$db = new Db();
$db->connect();

// Crea una nueva instancia de la aplicación Slim
$app = AppFactory::create();
$app->setBasePath('/app');

$app->addErrorMiddleware(true, true, true);

require 'routes/GenreRoutes.php';
require 'routes/PlatformRoutes.php';
require 'routes/GameRoutes.php';

$app->run();     
