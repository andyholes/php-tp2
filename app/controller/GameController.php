<?php
require __DIR__.'/../model/Game.php';

class GameController {
    private $db;

    public function __construct($db) {
        $this->db = $db->getDb();
    }

    public function createGame($name, $image, $desc, $url, $genre, $platform) {
        // decodifica la cadena base64        
        $img = base64_encode(file_get_contents($image));
        $type = image_type_to_mime_type($image);

        $query = "INSERT INTO juegos (nombre, imagen, tipo_imagen, descripcion, url, id_genero, id_plataforma) VALUES (?)";
        
        //TODO: validar si existe genero o plataforma con el id proporcionado

        $stmt = $this->db->prepare($query);
        $stmt->execute([$name, $img, $type, $desc, $url, $genre, $platform]);

        $id = $this->db->lastInsertId();
        $game = array('id'=>$id, 'nombre'=>$name, 'imagen'=>$img, 'imagen_tipo'=>$type, 'descripcion'=>$desc, 'url'=>$url, 'genero_id'=>$genre, 'plataforma_id'=>$platform);
        return $game;
    }

    public function updateGame($id, $name, $img, $desc, $url, $genre, $platform) {
        // decodifica la cadena base64
        $image = base64_encode(file_get_contents($img['tmp_name']));
        $type = $img['type'];

        $query = "UPDATE generos SET nombre, imagen, tipo_imagen, descripcion, url, id_genero, id_plataforma = ? WHERE id = ?";
        $genreQuery = "SELECT id FROM generos WHERE nombre = $genre";
        $platQuery = "SELECT id FROM plataformas WHERE nombre = $platform";
        
        $genreId = $this->db->execute($genreQuery);
        $platId = $this->db->execute($platQuery);
        $stmt = $this->db->prepare($query);
        $stmt->execute([$name, $image, $type, $desc, $url, $genreId, $platId, $id]);

        return new Game($id, $name, $image, $type, $desc, $url, $genreId, $platId);
    }

    public function getAllGames($queryParams) {
        $query = "SELECT id, nombre, descripcion, imagen, tipo_imagen, url, id_genero, id_plataforma FROM juegos";

        $reciboNombre = (isset($queryParams['nombre']) && ($queryParams['nombre'] != ""));
        $reciboGenero = (isset($queryParams['genero']) && ($queryParams['genero'] != ""));
        $reciboPlataforma = (isset($queryParams['plataforma']) && ($queryParams['plataforma'] != ""));
        $reciboOrden = (isset($queryParams['ordenar']) && ($queryParams['ordenar'] != ""));

        if ($reciboNombre) $nombre = $queryParams['nombre'];
        if ($reciboGenero) $genero = $queryParams['genero'];
        if ($reciboPlataforma) $plataforma = $queryParams['plataforma'];
        if ($reciboOrden) $orden = $queryParams['ordenar'];

        if ($reciboNombre || $reciboGenero || $reciboPlataforma){
            $query .= " WHERE ";
        }
        if ($reciboNombre){
            $query .= 'J.nombre LIKE "%'. $nombre .'%"';}

        if ($reciboGenero){
            if ($reciboNombre) {$query .= ' AND ';}
            $query .= 'J.id_genero = '. $genero;}

        if ($reciboPlataforma){
            if (($reciboNombre)  || ($reciboGenero)) {$query .= ' AND ';}
            $query .= 'J.id_plataforma = '. $plataforma;}
            
        if (($reciboOrden) && (($orden == "ASC") || ($orden == "DESC"))){
            $query .= ' ORDER BY J.nombre '. $orden;}
        $stmt = $this->db->query($query);
        $games = array();
        while ($row = $stmt->fetch()) {
            $game = array('id'=> $row['id'],'nombre'=> $row['nombre'], 'imagen'=>"\$row['imagen']", 'tipoImagen'=>$row['tipo_imagen'], 'descripcion'=>$row['descripcion'], 'url'=>$row['url'], 'idGenero'=>$row['id_genero'], 'idPlataforma'=>$row['id_plataforma']);
            $games[] = $game;
        }
        return $games;
    }

    public function deleteGame($id) {
        $query = "DELETE FROM juegos WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
    }
}
