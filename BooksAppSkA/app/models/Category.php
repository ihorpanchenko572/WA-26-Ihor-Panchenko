<?php

class Category {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Tuhle metodu tam už máš
    public function getAllCategories() {
        $stmt = $this->db->prepare("SELECT * FROM categories ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // !!! TUTO METODU TAM MUSÍŠ PŘIDAT !!!
    public function getAllSubcategories() {
        $sql = "SELECT * FROM subcategories ORDER BY name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}