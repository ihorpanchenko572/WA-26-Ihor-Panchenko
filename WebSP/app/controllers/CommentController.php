<?php
class CommentController {
    private $db;
    private $commentModel;

    public function __construct() {
        require_once '../app/models/Database.php';
        require_once '../app/models/Comment.php';
        require_once '../app/models/User.php';

        $database = new Database();
        $this->db = $database->getConnection();
        $this->commentModel = new Comment($this->db);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
            $workoutId = $_POST['workout_id'];
            $content = $_POST['content'];

            if (!empty($content)) {
                $this->commentModel->create($workoutId, $_SESSION['user_id'], $content);
            }
            header('Location: ' . BASE_URL . '/index.php?url=workout/show/' . $workoutId);
            exit;
        }
    }

    public function delete($id) {
        // Kontrola, zda je uživatel admin
        $userModel = new User($this->db);
        $user = $userModel->findById($_SESSION['user_id']);

        if ($user && $user['role'] === 'admin') {
            $this->commentModel->delete($id);
            // Vrátíme se zpět na předchozí stránku
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            header('Location: ' . BASE_URL . '/index.php');
        }
        exit;
    }
}