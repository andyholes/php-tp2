<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require 'controller/GenreController';

// Crea una instancia de la clase Db y GenreController
$db->getDb();
$genreController = new GenreController($db);

// Define las rutas en el objeto de la aplicación Slim
$app->get('/genres', function (Request $request, Response $response) use ($genreController) {
    $genres = $genreController->getAllGenres();

    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode($genres));

    return $response->withStatus(200);
});

$app->post('/genres', function (Request $request, Response $response) use ($genreController) {
    $data = $request->getParsedBody();

    if (empty($data['name'])) {
        throw new Exception('El campo "name" es requerido');
    }

    $genre = $genreController->createGenre($data['name']);

    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode($genre));

    return $response->withStatus(201);
});

$app->put('/genres/{id}', function (Request $request, Response $response, array $args) use ($genreController) {
    $id = $args['id'];
    $data = $request->getParsedBody();

    if (empty($data['name'])) {
        throw new Exception('El campo "name" es requerido');
    }

    $genre = $genreController->updateGenre($id, $data['name']);

    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode($genre));

    return $response->withStatus(200);
});

$app->delete('/genres/{id}', function (Request $request, Response $response, array $args) use ($genreController) {
    $id = $args['id'];

    $genreController->deleteGenre($id);

    return $response->withStatus(204);
});