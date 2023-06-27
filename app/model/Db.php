<?php
    class Db {
        private $host = '127.0.0.1';
        private $dbname = 'juegos_online';
        private $user = 'root';
        private $password = 'andyholes';
        private $db;
    
        public function connect() {
            try {
                $this->db = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
    
        public function getDb() {
            return $this->db;
        }
    }