<?php
class Comment {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Získání jednoho konkrétního komentáře podle ID (DOPLNĚNO PRO KONTROLU VLASTNICTVÍ)
    public function getById($id) {
        $sql = "SELECT * FROM comments WHERE id = :id LIMIT 0,1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Získání všech komentářů pro konkrétní trénink
    public function getByWorkoutId($workoutId) {
        $sql = "SELECT c.*, u.username, u.nickname 
                FROM comments c 
                JOIN users u ON c.user_id = u.id 
                WHERE c.workout_id = :workout_id 
                ORDER BY c.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':workout_id' => $workoutId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Uložení nového komentáře
    public function create($workoutId, $userId, $content) {
        $sql = "INSERT INTO comments (workout_id, user_id, content) VALUES (:workout_id, :user_id, :content)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':workout_id' => $workoutId,
            ':user_id' => $userId,
            ':content' => $content // Přesuneme htmlspecialchars až na výstup ve View, aby v DB byla čistá data
        ]);
    }

    // Aktualizace textu komentáře (DOPLNĚNO PRO EDITACI)
    public function update($id, $content) {
        $sql = "UPDATE comments SET content = :content WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':content' => $content,
            ':id' => $id
        ]);
    }

    // Smazání komentáře
    public function delete($id) {
        $sql = "DELETE FROM comments WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}