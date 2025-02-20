<?php

class Taches {
    private $id;
    private $titre;
    private $description;
    private $status;
    private $date_creation;

    public function __construct($id = null, $titre = "", $description = "", $status = 0, $date_creation = null) {
        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
        $this->status = $status;
        $this->date_creation = $date_creation;
    }

    
    public function getId() {
        return $this->id;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getDateCreation() {
        return $this->date_creation;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setDateCreation($date_creation) {
        $this->date_creation = $date_creation;
    }
}
