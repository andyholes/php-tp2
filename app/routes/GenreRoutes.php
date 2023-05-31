<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Crea una instancia de la clase Db y GenreController
$db->getDb();
require __DIR__ . '/../controller/GenreController.php';
$genreController = new GenreController($db);

// Define las rutas en el objeto de la aplicación Slim
$app->get('/genres', function (Request $request, Response $response) use ($genreController) {
    $genres = $genreController->getAllGenres();

    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode($genres));

    return $response->withStatus(200);
});

$app->post('/genres', function (Request $request, Response $response) use ($genreController) {
    $data = json_decode($request->getBody()->getContents(), true);

    if (empty($data['nombre'])) {
        return $response->withStatus(400)->getBody()->write('El campo "nombre" no puede estar vacio');
    }

    $genre = $genreController->createGenre($data['nombre']);

    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode($genre));

    return $response->withStatus(201);
});

$app->put('/genres/{id}', function (Request $request, Response $response, array $args) use ($genreController) {
    $id = $args['id'];
    $data = $request->getParsedBody();

    if (empty($data['nombre'])) {
        throw new Exception('El campo "nombre" es requerido');
    }

    $genre = $genreController->updateGenre($id, $data['nombre']);

    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode($genre));

    return $response->withStatus(200);
});

$app->delete('/genres/{id}', function (Request $request, Response $response, array $args) use ($genreController) {
    $id = $args['id'];

    $genreController->deleteGenre($id);

    return $response->withStatus(204);
});