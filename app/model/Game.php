<?php

class Game {
    private $id;
    private $name;
    private $img; 
    private $img_type;
    private $desc; 
    private $url; 
    private $genre; 
    private $platform; 

    public function __construct($id, $name, $img, $img_type, $desc, $url, $genre, $platform) {
        $this->id = $id;
        $this->name = $name;
        $this->$img = $img;
        $this->$img_type = $img_type; 
        $this->$desc = $desc; 
        $this->$url = $url; 
        $this->$genre = $genre; 
        $this->$platform = $platform; 
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getImg() {
        return $this->img;
    }

    public function getImgType() {
        return $this->img_type;
    }

    public function getDesc() {
        return $this->desc;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getGenre() {
        return $this->genre;
    }

    public function getPlatform() {
        return $this->platform;
    }
}
