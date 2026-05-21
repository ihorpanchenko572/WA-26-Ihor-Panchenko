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

        // GLOBÁLNÍ OCHRANA: Pro jakoukoliv operaci s uživateli musí být uživatel přihlášen
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['messages']['error'][] = "PRO VSTUP DO ARÉNY SE MUSÍŠ NEJDŘÍVE PŘIHLÁSIT!";
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }
    }

    // 1. ZORAZENÍ PROFILU AKTUÁLNÍHO UŽIVATELE
    public function profile() {
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findById($userId);

        if (!$user) {
            $this->addErrorMessage('PROFIL NEBYL NALEZEN.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/views/users/profile.php';
    }

    // 2. FORMULÁŘ PRO ÚPRAVU PROFILU
    public function edit() {
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findById($userId);

        if (!$user) {
            $this->addErrorMessage('PROFIL NEBYL NALEZEN.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/views/users/profile_edit.php';
    }

    // 3. ZPRACOVÁNÍ AKTUALIZACE PROFILU
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            
            // Načtení a vyčištění dat z formuláře
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $firstName = !empty($_POST['first_name']) ? trim($_POST['first_name']) : null;
            $lastName = !empty($_POST['last_name']) ? trim($_POST['last_name']) : null;
            $nickname = !empty($_POST['nickname']) ? trim($_POST['nickname']) : null;

            // Validace povinných polí
            if (empty($username) || empty($email)) {
                $this->addErrorMessage('PŘEZDÍVKA A EMAIL JSOU POVINNÁ POLE!');
                header('Location: ' . BASE_URL . '/index.php?url=user/edit');
                exit;
            }

            // Spuštění aktualizace v modelu
            if ($this->userModel->updateProfile($userId, $username, $email, $firstName, $lastName, $nickname)) {
                // Aktualizujeme uživatelské jméno v Session, aby se ihned změnilo v horní liště webu
                $_SESSION['user_name'] = $username;

                $this->addSuccessMessage('PROFIL BOJOVNÍKA BYL ÚSPĚŠNĚ AKTUALIZOVÁN.');
                header('Location: ' . BASE_URL . '/index.php?url=user/profile');
            } else {
                $this->addErrorMessage('NASTALA CHYBA PŘI UKLÁDÁNÍ DAT DO DATABÁZE.');
                header('Location: ' . BASE_URL . '/index.php?url=user/edit');
            }
            exit;
        }
    }

    // OSTRANĚNÍ UŽIVATELE (POUZE ADMIN)
    public function delete($id = null) {
        if (!$id) {
            $this->addErrorMessage('CHYBÍ ID UŽIVATELE.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Získání dat o aktuálně přihlášeném uživateli pro kontrolu role
        $currentUser = $this->userModel->findById($_SESSION['user_id']);

        // KLÍČOVÁ KONTROLA ROLE (RBAC)
        if (!$currentUser || $currentUser['role'] !== 'admin') {
            $this->addErrorMessage('PŘÍSTUP ZAMÍTNUT: POUZE ADMINISTRÁTOR MŮŽE MAZAT PROFILY.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Samotné smazání přes model
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