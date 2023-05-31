<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Crea una instancia de la clase PlatformController
$db->getDb();
require __DIR__ . '/../controller/PlatformController.php';
$platformController = new PlatformController($db);

// Define las rutas para las plataformas
$app->get('/platforms', function (Request $request, Response $response) use ($platformController) {
    $platforms = $platformController->getAllPlatforms();

    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode($platforms));

    return $response->withStatus(200);
});

$app->post('/platforms', function (Request $request, Response $response) use ($platformController) {
    $data = $request->getParsedBody();

    if (empty($data['nombre'])) {
        throw new Exception('El campo "nombre" es requerido');
    }

    $platform = $platformController->createPlatform($data['nombre']);

    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode($platform));

    return $response->withStatus(201);
});

$app->put('/platforms/{id}', function (Request $request, Response $response, array $args) use ($platformController) {
    $id = $args['id'];
    $data = $request->getParsedBody();

    if (empty($data['nombre'])) {
        throw new Exception('El campo "nombre" es requerido');
    }

    $platform = $platformController->updatePlatform($id, $data['nombre']);

    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode($platform));

    return $response->withStatus(200);
});

$app->delete('/platforms/{id}', function (Request $request, Response $response, array $args) use ($platformController) {
    $id = $args['id'];

    $platformController->deletePlatform($id);

    return $response->withStatus(204);
});