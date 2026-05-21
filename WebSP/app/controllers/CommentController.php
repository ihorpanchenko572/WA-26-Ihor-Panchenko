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

        // Ochrana: Pro jakoukoliv akci s komentáři musím být přihlášený
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $workoutId = $_POST['workout_id'];
            $content = trim($_POST['content']);

            if (!empty($content)) {
                $this->commentModel->create($workoutId, $_SESSION['user_id'], $content);
                $_SESSION['messages']['success'][] = 'KORBA OHLÁŠENA! KOMENTÁŘ BYL ZAPSÁN.';
            } else {
                $_SESSION['messages']['error'][] = 'NELZE ODESLAT PRÁZDNÝ KOMENTÁŘ.';
            }
            header('Location: ' . BASE_URL . '/index.php?url=workout/show/' . $workoutId);
            exit;
        }
    }

    // NOVÁ METODA: Zpracování aktualizace komentáře
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $comment = $this->commentModel->getById($id);
            $newContent = trim($_POST['content']);

            if (!$comment) {
                $_SESSION['messages']['error'][] = 'KOMENTÁŘ NEEXISTUJE.';
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            }

            // KONTROLA VLASTNICTVÍ: Pouze autor může upravovat
            if ($comment['user_id'] !== $_SESSION['user_id']) {
                $_SESSION['messages']['error'][] = 'ZÁSAH DO CIZÍHO TRÉNINKU ZAMÍTNUT!';
                header('Location: ' . BASE_URL . '/index.php?url=workout/show/' . $comment['workout_id']);
                exit;
            }

            if (!empty($newContent)) {
                $this->commentModel->update($id, $newContent);
                $_SESSION['messages']['success'][] = 'ZÁPIS V ARÉNĚ BYL UPRAVEN.';
            } else {
                $_SESSION['messages']['error'][] = 'KOMENTÁŘ NEMŮŽE BÝT PRÁZDNÝ.';
            }

            header('Location: ' . BASE_URL . '/index.php?url=workout/show/' . $comment['workout_id']);
            exit;
        }
    }

    public function delete($id) {
        $comment = $this->commentModel->getById($id);

        if (!$comment) {
            $_SESSION['messages']['error'][] = 'KOMENTÁŘ NEBYL NALEZEN.';
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Kontrola role přihlášeného uživatele (kvůli adminovi)
        $userModel = new User($this->db);
        $user = $userModel->findById($_SESSION['user_id']);
        $isAdmin = ($user && $user['role'] === 'admin');

        // AUTORIZACE: Smazat může buď autor komentáře, nebo administrátor
        if ($comment['user_id'] === $_SESSION['user_id'] || $isAdmin) {
            $this->commentModel->delete($id);
            $_SESSION['messages']['success'][] = 'KOMENTÁŘ BYL ODSTRANĚN.';
        } else {
            $_SESSION['messages']['error'][] = 'PŘÍSTUP ZAMÍTNUT: TENTO KOMENTÁŘ TI NEPATŘÍ.';
        }

        // Bezpečný návrat zpět na trénink
        header('Location: ' . BASE_URL . '/index.php?url=workout/show/' . $comment['workout_id']);
        exit;
    }
}