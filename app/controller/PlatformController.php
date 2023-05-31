<?php
class PlatformController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllPlatforms() {
        $query = "SELECT * FROM platforms";
        $stmt = $this->db->query($query);

        $platforms = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $platform = new Platform($row['id'], $row['nombre']);
            $platforms[] = $platform;
        }

        return $platforms;
    }

    public function createPlatform($nombre) {
        $query = "INSERT INTO platforms (nombre) VALUES (:nombre)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();

        $id = $this->db->lastInsertId();
        $platform = new Platform($id, $nombre);

        return $platform;
    }

    public function updatePlatform($id, $nombre) {
        $query = "UPDATE platforms SET nombre = :nombre WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $platform = new Platform($id, $nombre);

        return $platform;
    }

    public function deletePlatform($id) {
        $query = "DELETE FROM platforms WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}