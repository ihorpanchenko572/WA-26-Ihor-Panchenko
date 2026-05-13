<?php

// Tento řádek ručně připojí základní třídu, aby UserController věděl, co má rozšiřovat
require_once '../app/core/Controller.php';

class UserController extends Controller {
    private $userModel;

    public function __construct() {
        $dbObj = new Database();
        $db = $dbObj->getConnection();
        $this->userModel = new User($db);
    }

    public function delete($id) {
        // 1. Ochrana: Musí být přihlášen
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }

        // 2. Získání dat o přihlášeném uživateli (tobě)
        $currentUser = $this->userModel->findById($_SESSION['user_id']);

        // 3. KLÍČOVÁ KONTROLA ROLE
        if ($currentUser['role'] !== 'admin') {
            $this->addErrorMessage('CHYBA: POUZE ADMINISTRÁTOR MŮŽE MAZAT UŽIVATELE.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // 4. Samotné smazání
        if ($this->userModel->delete($id)) {
            $this->addSuccessMessage('UŽIVATEL BYL ÚSPĚŠNĚ ODSTRANĚN.');
        } else {
            $this->addErrorMessage('NASTALA CHYBA PŘI MAZÁNÍ.');
        }

        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }
}