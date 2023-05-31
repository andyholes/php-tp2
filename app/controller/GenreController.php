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

        $genreId = $this->db->lastInsertId();
        return new Genre($genreId, $nombre);
    }

    public function updateGenre($id, $nombre) {
        $query = "UPDATE generos SET nombre = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$nombre, $id]);

        return new Genre($id, $nombre);
    }

    public function getAllGenres() {
        $query = "SELECT * FROM generos";
        $stmt = $this->db->query($query);

        $genres = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $genre = array(
                'id' => $row['id'],
                'nombre' => $row['nombre']
            );
            $genres[] = $genre;
        }

        return $genres;
    }

    public function deleteGenre($id) {
        $query = "DELETE FROM generos WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
    }
}