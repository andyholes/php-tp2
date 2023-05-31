<?php

require '../vendor/autoload.php'; // Carga las dependencias de Slim PHP

use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
use Slim\Psr7\Response;

require 'model/Db.php';
$db = new Db();
$db->connect();

// Crea una nueva instancia de la aplicación Slim
$app = AppFactory::create();

// Incluye el archivo con las rutas
require 'routes/GenreRoutes.php';
require 'routes/PlatformRoutes.php';

$app->map(['GET', 'POST', 'PUT', 'DELETE'], '/{routes:.+}', function ($request, $response) {
    throw new HttpNotFoundException($request);
})->setName('notFound');

// Manejo de excepciones
$app->addErrorMiddleware(true, true, true);

// Ejecuta la aplicación Slim
$app->run();