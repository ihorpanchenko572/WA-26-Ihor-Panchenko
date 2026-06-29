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
public function getAll($muscleGroupId = null, $searchQuery = null) {
    $sql = "SELECT w.*, m.name as muscle_group
            FROM workouts w
            LEFT JOIN muscle_groups m ON w.muscle_group = m.id";

    $conditions = [];
    if ($muscleGroupId) {
        $conditions[] = "w.muscle_group = :muscle_group_id";
    }
    if ($searchQuery) {
        $conditions[] = "w.exercise_name LIKE :search";
    }
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $sql .= " ORDER BY w.created_at DESC";

    $stmt = $this->db->prepare($sql);

    if ($muscleGroupId) {
        $stmt->bindValue(':muscle_group_id', (int)$muscleGroupId, PDO::PARAM_INT);
    }
    if ($searchQuery) {
        $stmt->bindValue(':search', '%' . $searchQuery . '%', PDO::PARAM_STR);
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
    public function getWeightStats() {
    // SQL spočítá celkovou váhu (weight * sets * reps) pro každý den
    // Použijeme DATE(), aby se odřízl čas a seskupovalo se čistě podle dnů
    $sql = "SELECT DATE(workout_date) as date, SUM(weight * sets * reps) as total_weight 
            FROM workouts 
            GROUP BY DATE(workout_date) 
            ORDER BY DATE(workout_date) ASC 
            LIMIT 30"; // Vezmeme posledních 30 dní s aktivitou
            
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}