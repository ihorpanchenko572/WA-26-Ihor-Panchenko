<?php

class Subcategory {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Metoda pro získání všech hlavních kategorií
    public function getAllCategories() {
        $stmt = $this->db->prepare("SELECT * FROM categories ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // NOVÁ METODA: Získání subkategorií pro konkrétní hlavní kategorii
    // Toto využiješ, až budeš chtít filtrovat podkategorie podle vybrané kategorie
    public function getSubcategoriesByCategory($categoryId) {
        $stmt = $this->db->prepare("SELECT * FROM subcategories WHERE category_id = :category_id ORDER BY name ASC");
        $stmt->execute([':category_id' => $categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Metoda pro získání ÚPLNĚ VŠECH subkategorií (pokud je chceš načíst najednou)
    public function getAllSubcategories() {
        $stmt = $this->db->prepare("SELECT * FROM subcategories ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}