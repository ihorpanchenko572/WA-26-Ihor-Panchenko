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
    public function getAll() {
        $sql = "SELECT * FROM workouts ORDER BY workout_date DESC, id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        // Vrací pole všech tréninků
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
    public function create($exercise, $muscle, $weight, $reps, $sets, $date, $description, $images): bool {
        $sql = "INSERT INTO workouts (exercise_name, muscle_group, weight, reps, sets, workout_date, description, images)
                VALUES (:exercise, :muscle, :weight, :reps, :sets, :date, :description, :images)";
        
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':exercise'    => $exercise,
            ':muscle'      => $muscle,
            ':weight'      => $weight,
            ':reps'        => $reps,
            ':sets'        => $sets,
            ':date'        => $date,
            ':description' => $description,
            ':images'      => json_encode($images) // Pole fotek uložíme jako JSON text
        ]);
    }

    /**
     * Aktualizace existujícího tréninku (TATO METODA TI CHYBĚLA)
     */
    public function update($id, $exercise, $muscle, $weight, $reps, $sets, $date, $description, $images): bool {
        $sql = "UPDATE workouts 
                SET exercise_name = :exercise, 
                    muscle_group = :muscle, 
                    weight = :weight, 
                    reps = :reps, 
                    sets = :sets, 
                    workout_date = :date, 
                    description = :description, 
                    images = :images
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
            ':images'      => json_encode($images)
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