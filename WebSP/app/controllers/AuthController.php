<?php

class AuthController {

    // 1. Zobrazení registračního formuláře
    public function register() {
        require_once '../app/views/auth/register.php';
    }

    // 2. Zpracování dat z registrace
    public function storeUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Očištění textových vstupů
            $username = htmlspecialchars($_POST['username'] ?? '');
            $email = htmlspecialchars($_POST['email'] ?? '');
            $firstName = htmlspecialchars($_POST['first_name'] ?? '');
            $lastName = htmlspecialchars($_POST['last_name'] ?? '');
            $nickname = htmlspecialchars($_POST['nickname'] ?? '');
            
            // Hesla neočišťujeme (kvůli speciálním znakům), ale budeme je validovat
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';

            // --- VALIDACE ---

            // A) Jsou vyplněna povinná pole?
            if (empty($username) || empty($email) || empty($password)) {
                $this->addErrorMessage('VYPLŇTE PROSÍM VŠECHNA POVINNÁ POLE.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }

            // B) Shodují se hesla?
            if ($password !== $passwordConfirm) {
                $this->addErrorMessage('ZADANÁ HESLA SE NESHODUJÍ.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }

            // C) BEZPEČNOST: Minimální délka 8 znaků
            if (strlen($password) < 8) {
                $this->addErrorMessage('HESLO JE PŘÍLIŠ KRÁTKÉ (MIN. 8 ZNAKŮ).');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }

            // D) BEZPEČNOST: Alespoň jedno velké písmeno
            if (!preg_match('/[A-Z]/', $password)) {
                $this->addErrorMessage('HESLO MUSÍ OBSAHOVAT ALESPOŇ JEDNO VELKÉ PÍSMENO.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }

            // --- KONEC VALIDACE ---

            // Napojení na DB a Model
            require_once '../app/models/Database.php';
            require_once '../app/models/User.php';
            
            $db = (new Database())->getConnection();
            $userModel = new User($db);

            // Pokus o uložení do databáze
            if ($userModel->register($username, $email, $password, $firstName, $lastName, $nickname)) {
                $this->addSuccessMessage('REGISTRACE ÚSPĚŠNÁ. TEĎ SE PŘIHLAŠ.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            } else {
                $this->addErrorMessage('UŽIVATEL S TÍMTO E-MAILEM JIŽ EXISTUJE.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }
        }
    }

    // 3. Zobrazení přihlašovacího formuláře
    public function login() {
        require_once '../app/views/auth/login.php';
    }

    // 4. Zpracování přihlášení (Ověření uživatele)
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = htmlspecialchars($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            require_once '../app/models/Database.php';
            require_once '../app/models/User.php';
            
            $db = (new Database())->getConnection();
            $userModel = new User($db);

            $user = $userModel->findByEmail($email);

            // password_verify porovná zadané heslo s hashem v DB
            if ($user && password_verify($password, $user['password'])) {
                
                // Uložení dat do Session
                $_SESSION['user_id'] = $user['id'];
                
                // Priorita pro jméno: 1. Nickname, 2. Username
                $_SESSION['user_name'] = !empty($user['nickname']) ? $user['nickname'] : $user['username'];

                $this->addSuccessMessage('VÍTEJ V ARÉNĚ, ' . $_SESSION['user_name'] . '!');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
                
            } else {
                $this->addErrorMessage('NESPRÁVNÝ E-MAIL NEBO HESLO.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }
        }
    }

    // 5. Odhlášení uživatele
    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        
        $this->addSuccessMessage('BYL JSI ODHLÁŠEN. PŘIĎ ZAS!');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // --- Pomocné metody pro zprávy ---
    protected function addSuccessMessage($message) {
        $_SESSION['messages']['success'][] = $message;
    }

    protected function addErrorMessage($message) {
        $_SESSION['messages']['error'][] = $message;
    }
}