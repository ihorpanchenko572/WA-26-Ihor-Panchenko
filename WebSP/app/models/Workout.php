<?php

class Workout {
    // Definice, že proměnná $db musí být vždy instancí třídy PDO
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;    
    }

    /**
     * Získání všech tréninků z databáze (od nejnovějších)
     */
public function getAll($muscleGroupId = null) {
    // Spojíme workouts s tabulkou muscle_groups podle ID, abychom získali textový název (name) jako 'muscle_group'
    $sql = "SELECT w.*, m.name as muscle_group 
            FROM workouts w
            LEFT JOIN muscle_groups m ON w.muscle_group = m.id";
            
    // Pokud uživatel vybral filtr, filtrujeme podle ID svalové skupiny
    if ($muscleGroupId) {
        $sql .= " WHERE w.muscle_group = :muscle_group_id";
    }
    
    // Seřadíme tréninky od nejnověji vytvořených
    $sql .= " ORDER BY w.created_at DESC";
    
    $stmt = $this->db->prepare($sql);
    
    // Pokud máme filtr, bezpečně navážeme integer hodnotu (obrana proti SQL Injection)
    if ($muscleGroupId) {
        $stmt->bindValue(':muscle_group_id', (int)$muscleGroupId, PDO::PARAM_INT);
    }
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    /**
     * Získání jednoho konkrétního tréninku podle jeho ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM workouts WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        // Vrátí jeden záznam nebo false
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Vytvoření nového tréninkového záznamu
     */
    public function create(
        string $exercise,
        int $muscle,
        float $weight,
        int $reps,
        int $sets,
        string $date,
        string $description,
        array $images,
        int $userId // !!! ZMĚNA: NOVÝ PARAMETR PRO ID UŽIVATELE
        ): bool {
        $sql = "INSERT INTO workouts (exercise_name, muscle_group, weight, reps, sets, workout_date, description, images, created_by)
                VALUES (:exercise, :muscle, :weight, :reps, :sets, :date, :description, :images, :created_by)";
        
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':exercise'    => $exercise,
            ':muscle'      => $muscle,
            ':weight'      => $weight,
            ':reps'        => $reps,
            ':sets'        => $sets,
            ':date'        => $date,
            ':description' => $description,
            ':images'      => json_encode($images), // Pole fotek uložíme jako JSON text
            ':created_by' => $userId // !!! ZMĚNA: Předání ID do databáze
        ]);
    }

    /**
     * Aktualizace existujícího tréninku (TATO METODA TI CHYBĚLA)
     */
    /**
     * Aktualizace existujícího tréninku (UPRAVENO O UPDATED_BY)
     */
    public function update($id, $exercise, $muscle, $weight, $reps, $sets, $date, $description, $images, $userId = null): bool {
        // !!! ZMĚNA: Přidán sloupec updated_by do SET části
        $sql = "UPDATE workouts 
                SET exercise_name = :exercise, 
                    muscle_group = :muscle, 
                    weight = :weight, 
                    reps = :reps, 
                    sets = :sets, 
                    workout_date = :date, 
                    description = :description, 
                    images = :images,
                    updated_by = :updated_by
                WHERE id = :id";
                
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id'          => $id,
            ':exercise'    => $exercise,
            ':muscle'      => $muscle,
            ':weight'      => $weight,
            ':reps'        => $reps,
            ':sets'        => $sets,
            ':date'        => $date,
            ':description' => $description,
            ':images'      => json_encode($images),
            ':updated_by'  => $userId // !!! ZMĚNA: Předání ID přihlášeného uživatele
        ]);
    }

    /**
     * Smazání tréninku z databáze
     */
    public function delete($id) {
        $sql = "DELETE FROM workouts WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([':id' => $id]);
    }
}