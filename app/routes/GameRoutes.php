<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Crea una instancia de la clase Db y GameController
$db->getDb();
require __DIR__ . '/../controller/GameController.php';
$gameController = new GameController($db);

// Define las rutas en el objeto de la aplicaciÃ³n Slim
$app->get('/games', function (Request $request, Response $response) use ($gameController) {
    $games = $gameController->getAllGames();

    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode($games));

    return $response->withStatus(200);
});

$app->post('/games', function (Request $request, Response $response) use ($gameController) {
    $data = $request->getQueryParams();

    if (empty($data['name'])) {
        throw new Exception('El campo "name" es requerido');
    }
    if (empty($data['img'])) {
        throw new Exception('El campo "image" es requerido');
    }
    if (empty($data['desc'])) {
        throw new Exception('El campo "description" es requerido');
    }
    if (empty($data['url'])) {
        throw new Exception('El campo "url" es requerido');
    }
    if (empty($data['genre'])) {
        throw new Exception('El campo "genre" es requerido');
    }
    if (empty($data['platform'])) {
        throw new Exception('El campo "platform" es requerido');
    }
    
    $game = $gameController->createGame($data['name'], $data['image'], $data['desc'], $data['url'], $data['genre'], $data['platform']);

    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode($game));

    return $response->withStatus(201);
});

$app->put('/games/{id}', function (Request $request, Response $response, array $args) use ($gameController) {
    $id = $args['id'];
    $data = $request->getParsedBody();

    if (empty($data['name'])) {
        throw new Exception('El campo "name" es requerido');
    }
    if (empty($data['img'])) {
        throw new Exception('El campo "image" es requerido');
    }
    if (empty($data['desc'])) {
        throw new Exception('El campo "description" es requerido');
    }
    if (empty($data['url'])) {
        throw new Exception('El campo "url" es requerido');
    }
    if (empty($data['genre'])) {
        throw new Exception('El campo "genre" es requerido');
    }
    if (empty($data['platform'])) {
        throw new Exception('El campo "platform" es requerido');
    }

    $game = $gameController->updateGame($id, $data['name'], $data['img'], $data['desc'], $data['url'], $data['genre'], $data['platform']);

    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode($game));

    return $response->withStatus(200);
});

$app->delete('/games/{id}', function (Request $request, Response $response, array $args) use ($gameController) {
    $id = $args['id'];

    $gameController->deleteGame($id);

    return $response->withStatus(204);
});

$app->get('/games/filter', function (Request $request, Response $response, array $args) use ($gameController) {
    $data = $request->getParsedBody();

    $games = $gameController->searchGame($data['name'], $data['genre'], $data['platform'], $data['order']);

    if ($games = "No hay resultados") {
        $response = $response->withHeader('content-type', 'application/json');
        $response->getBody()->write(json_encode($games)); 

        return $response->withStatus(404); 
    }
    else {
        $response = $response->withHeader('content-type', 'application/json');
        $response->getBody()->write(json_encode($games)); 

        return $response->withStatus(200);   
    }
});