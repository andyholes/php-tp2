<?php
require __DIR__.'/../model/Genre.php';

class GenreController {
    private $db;

    public function __construct($db) {
        $this->db = $db->getDb();
    }

    public function createGenre($nombre) {
        $query = "INSERT INTO generos (nombre) VALUES (?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$nombre]);
        $id = $this->db->lastInsertId();
        return array('id'=>$id,'nombre'=>$nombre);
    }

    public function updateGenre($id, $nombre) {
        $query = "UPDATE generos SET nombre = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$nombre, $id]);
        return array('id'=>$id,'nombre'=>$nombre);
    }

    public function getAllGenres() {
        $query = "SELECT * FROM generos";
        $stmt = $this->db->query($query);
        $genres = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $genre = array('id' => $row['id'], 'nombre' => $row['nombre']);
            $genres[] = $genre;
        }
        return $genres;
    }

    public function deleteGenre($id) {
        $query = "DELETE FROM generos WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
    }

    public function existsById($id){
        $query = "SELECT id FROM generos WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return ($stmt->rowCount()!=0);
    }
}