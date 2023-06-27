<?php

require '../vendor/autoload.php'; // Carga las dependencias de Slim PHP

use Slim\Factory\AppFactory;
use Tuupola\Middleware\CorsMiddleware;

require 'model/Db.php';
$db = new Db();
$db->connect();

// Crea una nueva instancia de la aplicación Slim
$app = AppFactory::create();
$app->setBasePath('/app');

$app->addErrorMiddleware(true, true, true);

$app->add(new CorsMiddleware([
    "origin" => ["http://localhost:3001"],
    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
    "headers.allow" => ["Authorization", "Content-Type"],
    "headers.expose" => [],
    "credentials" => true,
    "cache" => 0,
]));

require 'routes/GenreRoutes.php';
require 'routes/PlatformRoutes.php';
require 'routes/GameRoutes.php';

$app->run();     
