<?php

class WorkoutController {

    // 1. VÝPIS VŠECH TRÉNINKŮ (HISTORIE)
    public function index() {
        require_once '../app/models/Database.php';
        require_once '../app/models/Workout.php';

        $database = new Database();
        $db = $database->getConnection();

        $workoutModel = new Workout($db);
        $workouts = $workoutModel->getAll(); 
        
        require_once '../app/views/workouts/workouts_list.php';
    }

    // 2. DETAIL KONKRÉTNÍHO VÝKONU
    public function show($id = null) {
        if (!$id) {
            $this->addErrorMessage('CHYBÍ ID ZÁZNAMU.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Workout.php';

        $database = new Database();
        $db = $database->getConnection();

        $workoutModel = new Workout($db);
        $workout = $workoutModel->getById($id);

        if (!$workout) {
            $this->addErrorMessage('TRÉNINK NEBYL NALEZEN.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/views/workouts/workout_show.php';
    }

    // 3. FORMULÁŘ PRO NOVÝ ZÁPIS
    public function create() {
        // !!! ZMĚNA: Autorizace: Pokud uživatel není přihlášen, nemá tu co dělat
    if (!isset($_SESSION['user_id'])) {
        $this->addErrorMessage('Pro přidání výkonu se musíte nejprve přihlásit.');
        header('Location: ' . BASE_URL . '/index.php?url=auth/login');
        exit;
    }
        require_once '../app/views/workouts/workout_create.php';
    }

    // 4. ULOŽENÍ NOVÉHO TRÉNINKU
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // !!! ZMĚNA: ZDE PŘIDÁME KONTROLU PŘIHLÁŠENÍ ---
            if (!isset($_SESSION['user_id'])) {
                $this->addErrorMessage('Pro uložení výkonu musíte být přihlášeni.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }
            $userId = $_SESSION['user_id'];
            // ---------------------------------------
            
            $exercise = htmlspecialchars($_POST['exercise_name'] ?? '');
            $muscle = htmlspecialchars($_POST['muscle_group'] ?? '');
            $weight = (float)($_POST['weight'] ?? 0);
            $reps = (int)($_POST['reps'] ?? 0);
            $sets = (int)($_POST['sets'] ?? 0);
            $date = $_POST['workout_date'] ?? date('Y-m-d');
            $description = htmlspecialchars($_POST['description'] ?? '');

            // Zpracování obrázků
            $uploadedImages = $this->processImageUploads(); 

            require_once '../app/models/Database.php';
            require_once '../app/models/Workout.php';

            $database = new Database();
            $db = $database->getConnection();

            $workoutModel = new Workout($db);
            $isSaved = $workoutModel->create($exercise, $muscle, $weight, $reps, $sets, $date, $description, $uploadedImages, $userId);

            if ($isSaved) {
                $this->addSuccessMessage('VÝKON BYL ZAPSÁN. DOBRÁ PRÁCE!');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                $this->addErrorMessage('CHYBA PŘI UKLÁDÁNÍ.');
            }
        }
    }

    // 5. FORMULÁŘ PRO EDITACI
    public function edit($id = null) {

         // 🔒 !!! ZMĚNA: Kontrola, zda je uživatel přihlášen. 
        // Pokud není, nepustíme ho ani k načítání dat z DB.
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro úpravu výkonu se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        if (!$id) {
            $this->addErrorMessage('CHYBÍ ID.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Workout.php';

        $database = new Database();
        $db = $database->getConnection();

        $workoutModel = new Workout($db);
        $workout = $workoutModel->getById($id);

        if (!$workout) {
            $this->addErrorMessage('ZÁZNAM NENALEZEN.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // 🛡️ !!! ZMĚNA: Kontrola vlastnictví (Autorizace).
        // Ověříme, zda ID přihlášeného uživatele odpovídá ID autora uloženého u výkonu.
        if ($book['created_by'] !== $_SESSION['user_id']) {
            $this->addErrorMessage('Nemáte oprávnění upravovat tento výkon, protože nejste autorem.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/views/workouts/workout_edit.php';
    }

    // 6. AKTUALIZACE STÁVAJÍCÍHO ZÁZNAMU
    // 5. Zpracování dat odeslaných z editačního formuláře (FITNESS VERZE)
    public function update($id = null) {
        // Zabezpečení: Je k dispozici ID?
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID záznamu k aktualizaci.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 🔒 KONTROLA: Je uživatel přihlášen?
            if (!isset($_SESSION['user_id'])) {
                $this->addErrorMessage('Pro uložení změn se musíte nejprve přihlásit.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }

            // 🛡️ PŘÍPRAVA MODELU: Potřebujeme data z DB pro kontrolu vlastnictví
            require_once '../app/models/Database.php';
            require_once '../app/models/Workout.php';

            $database = new Database();
            $db = $database->getConnection();
            $workoutModel = new Workout($db);

            $workout = $workoutModel->getById($id);

            // 🛡️ AUTORIZACE: Patří tento trénink přihlášenému uživateli?
            // (Předpokládáme, že v tabulce workouts máš sloupec user_id nebo created_by)
            if (!$workout || $workout['user_id'] !== $_SESSION['user_id']) {
                $this->addErrorMessage('Nemáte oprávnění upravovat tento trénink, protože nejste jeho autorem.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            }

            // --- POKUD KONTROLY PROŠLY, ZPRACOVÁVÁME DATA ---

            $exercise = htmlspecialchars($_POST['exercise_name'] ?? '');
            $muscle = htmlspecialchars($_POST['muscle_group'] ?? '');
            $weight = (float)($_POST['weight'] ?? 0);
            $reps = (int)($_POST['reps'] ?? 0);
            $sets = (int)($_POST['sets'] ?? 0);
            $date = $_POST['workout_date'] ?? date('Y-m-d');
            $description = htmlspecialchars($_POST['description'] ?? '');

            // Zpracování nových obrázků
            $uploadedImages = $this->processImageUploads(); 

            // --- ZÁCHRANNÁ BRZDA PRO OBRÁZKY ---
            // Pokud uživatel nenahrál nové fotky, zachováme ty původní
            if (empty($uploadedImages)) {
                $uploadedImages = json_decode($workout['images'] ?? '[]', true);
            }

            // Volání updatu nad modelem
            $isUpdated = $workoutModel->update(
                $id, $exercise, $muscle, $weight, $reps, $sets, $date, $description, $uploadedImages
            );

            if ($isUpdated) {
                $this->addSuccessMessage('TRÉNINK BYL ÚSPĚŠNĚ AKTUALIZOVÁN.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                $this->addErrorMessage('NASTALA CHYBA PŘI UKLÁDÁNÍ ZMĚN.');
            }
            
        } else {
            // Pokud někdo přistoupí na URL přímo bez POSTu
            $this->addNoticeMessage('Pro úpravu záznamu je nutné odeslat formulář.');
        }
    }
    // 7. SMAZÁNÍ VÝKONU
    // 7. Smazání existujícího výkonu (ZABEZPEČENÁ VERZE)
    public function delete($id = null) {
        // 🔒 KONTROLA AUTENTIZACE: Je uživatel vůbec v systému?
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro smazání výkonu se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        // Kontrola, zda bylo v URL předáno ID
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID záznamu ke smazání.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Načtení potřebných tříd a spojení s databází
        require_once '../app/models/Database.php';
        require_once '../app/models/Workout.php';

        $database = new Database();
        $db = $database->getConnection();
        $workoutModel = new Workout($db);

        // 🛡️ KONTROLA AUTORIZACE (Vlastnictví): Nejdříve musíme trénink načíst
        $workout = $workoutModel->getById($id);

        // Pokud trénink v DB neexistuje
        if (!$workout) {
            $this->addErrorMessage('Záznam nebyl nalezen, pravděpodobně již byl smazán.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // 🛡️ HLAVNÍ ZEĎ: Ověříme, zda je aktuálně přihlášený uživatel autorem záznamu
        // (Změň 'user_id' na 'created_by', pokud to tak máš v databázi)
        if ($workout['user_id'] !== $_SESSION['user_id']) {
            $this->addErrorMessage('Nemáte oprávnění smazat tento záznam, protože nejste jeho autorem.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // 🛡️ FINÁLNÍ KROK: Teprve po úspěšném ověření provedeme samotné smazání
        $isDeleted = $workoutModel->delete($id);

        // Vyhodnocení výsledku a přesměrování s notifikací
        if ($isDeleted) {
            $this->addSuccessMessage('VÁŠ VÝKON BYL TRVALE SMAZÁN Z HISTORIE.');
        } else {
            $this->addErrorMessage('Nastala chyba. Záznam se nepodařilo smazat.');
        }

        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // --- POMOCNÉ METODY ---

    protected function addSuccessMessage($message) {
        $_SESSION['messages']['success'][] = $message;
    }

     protected function addNoticeMessage($message) {
        // Žlutá informativní zpráva
        $_SESSION['messages']['notice'][] = $message;
    }

    protected function addErrorMessage($message) {
        $_SESSION['messages']['error'][] = $message;
    }

    protected function processImageUploads() {
        $uploadedFiles = [];
        $uploadDir = __DIR__ . '/../../public/uploads/'; 
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $fileCount = count($_FILES['images']['name']);

            for ($i = 0; $i < $fileCount; $i++) {
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES['images']['tmp_name'][$i];
                    $originalName = basename($_FILES['images']['name'][$i]);
                    $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                    if (!in_array($fileExtension, $allowedExtensions)) {
                        continue;
                    }

                    $newName = 'gym_' . uniqid() . '.' . $fileExtension;
                    if (move_uploaded_file($tmpName, $uploadDir . $newName)) {
                        $uploadedFiles[] = $newName; 
                    }
                }
            }
        }
        return $uploadedFiles;
    }
}