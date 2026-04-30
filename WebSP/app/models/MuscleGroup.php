<?php

class MuscleGroup {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Získání všech svalových skupin pro select ve formuláři
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM muscle_groups ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}