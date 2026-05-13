<?php

class UserController {
    private $userModel;
    private $db;

    public function __construct() {
        // Načtení potřebných modelů, protože v tomto souboru nejsou dostupné automaticky
        require_once '../app/models/Database.php';
        require_once '../app/models/User.php';
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->userModel = new User($this->db);
    }

    public function delete($id = null) {
        // 1. Ochrana: Musí být přihlášen
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        if (!$id) {
            $this->addErrorMessage('CHYBÍ ID UŽIVATELE.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // 2. Získání dat o aktuálně přihlášeném uživateli pro kontrolu role
        $currentUser = $this->userModel->findById($_SESSION['user_id']);

        // 3. KLÍČOVÁ KONTROLA ROLE (RBAC)
        if (!$currentUser || $currentUser['role'] !== 'admin') {
            $this->addErrorMessage('PŘÍSTUP ZAMÍTNUT: POUZE ADMINISTRÁTOR MŮŽE MAZAT PROFILY.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // 4. Samotné smazání přes model
        if ($this->userModel->delete($id)) {
            $this->addSuccessMessage('UŽIVATEL BYL ÚSPĚŠNĚ ODSTRANĚN ZE SYSTÉMU.');
        } else {
            $this->addErrorMessage('NASTALA CHYBA PŘI KOMUNIKACI S DATABÁZÍ.');
        }

        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // Pomocné metody pro správu upozornění v Session (musí zde být, protože UserController nedědí od rodiče)
    protected function addSuccessMessage($message) {
        $_SESSION['messages']['success'][] = $message;
    }

    protected function addErrorMessage($message) {
        $_SESSION['messages']['error'][] = $message;
    }
}