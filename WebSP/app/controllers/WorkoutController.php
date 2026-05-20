<?php

class WorkoutController {

    // 1. VÝPIS VŠECH TRÉNINKŮ (HISTORIE)
public function index() {
    require_once '../app/models/Database.php';
    require_once '../app/models/Workout.php';
    require_once '../app/models/User.php';
    require_once '../app/models/MuscleGroup.php'; // PŘIDÁNO: Potřebujeme model svalových skupin

    $database = new Database();
    $db = $database->getConnection();

    // 1. Zjistíme, jestli uživatel kliknul na nějaký filtr v URL (např. &muscle_group_id=3)
    $selectedMuscleGroup = isset($_GET['muscle_group_id']) ? (int)$_GET['muscle_group_id'] : null;

    // 2. Načteme tréninky (pokud je vybraný filtr, getAll ho aplikuje podle ID)
    $workoutModel = new Workout($db);
    $workouts = $workoutModel->getAll($selectedMuscleGroup); 

    // 3. Načteme všechny svalové skupiny z DB pro vykreslení tlačítek filtru
    $mgModel = new MuscleGroup($db);
    $muscleGroups = $mgModel->getAll();
    
    // --- Zjištění role přihlášeného uživatele pro hlavní přehled ---
    $currentUserRole = 'user'; // výchozí
    if (isset($_SESSION['user_id'])) {
        $userModel = new User($db);
        $user = $userModel->findById($_SESSION['user_id']);
        if ($user) {
            $currentUserRole = $user['role'] ?? 'user';
        }
    }
    // -----------------------------------------------------------------------
    
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
    require_once '../app/models/User.php';
    require_once '../app/models/Comment.php'; // KROK 4: Načtení modelu komentářů

    $database = new Database();
    $db = $database->getConnection();

    $workoutModel = new Workout($db);
    $workout = $workoutModel->getById($id);

    if (!$workout) {
        $this->addErrorMessage('TRÉNINK NEBYL NALEZEN.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // --- Zjištění role pro šablonu ---
    $currentUserRole = 'user'; 
    if (isset($_SESSION['user_id'])) {
        $userModel = new User($db);
        $user = $userModel->findById($_SESSION['user_id']);
        if ($user) {
            $currentUserRole = $user['role'] ?? 'user';
        }
    }

    // --- KROK 4: Načtení komentářů pro tento trénink ---
    $commentModel = new Comment($db);
    $comments = $commentModel->getByWorkoutId($id);
    // --------------------------------------------------

    require_once '../app/views/workouts/workout_show.php';
}

    // 3. FORMULÁŘ PRO NOVÝ ZÁPIS
   // 3. FORMULÁŘ PRO NOVÝ ZÁPIS (UPRAVENO PRO SVALOVÉ SKUPINY)
    public function create() {
        // 1. Kontrola přihlášení
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('PRO PŘIDÁNÍ VÝKONU SE MUSÍTE NEJPRVE PŘIHLÁSIT.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        // 2. Načtení potřebných modelů
        require_once '../app/models/Database.php';
        require_once '../app/models/MuscleGroup.php'; // Tvůj nový model

        $database = new Database();
        $db = $database->getConnection();

        // 3. Získání svalových skupin z databáze
        $mgModel = new MuscleGroup($db);
        $muscleGroups = $mgModel->getAll(); 

        // 4. Předání dat do pohledu
        // Proměnná $muscleGroups bude nyní dostupná v souboru workout_create.php
        require_once '../app/views/workouts/workout_create.php';
    }

    // 4. ULOŽENÍ NOVÉHO TRÉNINKU
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!isset($_SESSION['user_id'])) {
                $this->addErrorMessage('PRO ULOŽENÍ VÝKONU MUSÍTE BÝT PŘIHLÁŠENI.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }
            
            $userId = $_SESSION['user_id'];
            
            $exercise = htmlspecialchars($_POST['exercise_name'] ?? '');

            // 🛡️ ZMĚNA: Svalová skupina k nám nyní chodí jako číslo (ID z value atributu selectu)
            $muscle = (int)($_POST['muscle_group'] ?? 0);

            $weight = (float)($_POST['weight'] ?? 0);
            $reps = (int)($_POST['reps'] ?? 0);
            $sets = (int)($_POST['sets'] ?? 0);
            $date = $_POST['workout_date'] ?? date('Y-m-d');
            $description = htmlspecialchars($_POST['description'] ?? '');

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
    // 5. FORMULÁŘ PRO EDITACI (UPRAVENO PRO SVALOVÉ SKUPINY)
    public function edit($id = null) {
    if (!isset($_SESSION['user_id'])) {
        $this->addErrorMessage('PRO ÚPRAVU VÝKONU SE MUSÍTE NEJPRVE PŘIHLÁSIT.');
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
    require_once '../app/models/MuscleGroup.php';
    require_once '../app/models/User.php'; // PŘIDÁNO: Potřebujeme zjistit roli

    $database = new Database();
    $db = $database->getConnection();

    $workoutModel = new Workout($db);
    $workout = $workoutModel->getById($id);

    if (!$workout) {
        $this->addErrorMessage('ZÁZNAM NENALEZEN.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // 🛡️ ZJIŠTĚNÍ ROLE AKTUÁLNÍHO UŽIVATELE
    $userModel = new User($db);
    $currentUser = $userModel->findById($_SESSION['user_id']);
    $isAdmin = ($currentUser && $currentUser['role'] === 'admin');

    // 🛡️ KONTROLA OPRÁVNĚNÍ (Majitel NEBO Admin)
    if ($workout['created_by'] !== $_SESSION['user_id'] && !$isAdmin) {
        $this->addErrorMessage('NEMÁTE OPRÁVNĚNÍ UPRAVOVAT TENTO VÝKON.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    $mgModel = new MuscleGroup($db);
    $muscleGroups = $mgModel->getAll(); 

    require_once '../app/views/workouts/workout_edit.php';
}
    // 6. AKTUALIZACE STÁVAJÍCÍHO ZÁZNAMU
    // 6. AKTUALIZACE STÁVAJÍCÍHO ZÁZNAMU
    public function update($id = null) {
        if (!$id) {
            $this->addErrorMessage('NEBYLO ZADÁNO ID ZÁZNAMU.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            if (!isset($_SESSION['user_id'])) {
                $this->addErrorMessage('PRO ULOŽENÍ ZMĚN SE MUSÍTE PŘIHLÁSIT.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }

            $userId = $_SESSION['user_id'];

            require_once '../app/models/Database.php';
            require_once '../app/models/Workout.php';

            $database = new Database();
            $db = $database->getConnection();
            $workoutModel = new Workout($db);

            $workout = $workoutModel->getById($id);

            if (!$workout || $workout['created_by'] !== $_SESSION['user_id']) {
                $this->addErrorMessage('NEMÁTE OPRÁVNĚNÍ UPRAVOVAT TENTO TRÉNINK.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            }

            $exercise = htmlspecialchars($_POST['exercise_name'] ?? '');

            // 🛡️ ZMĚNA: Stejně jako ve store, i tady ukládáme ID svalové skupiny jako celé číslo
            $muscle = (int)($_POST['muscle_group'] ?? 0);

            $weight = (float)($_POST['weight'] ?? 0);
            $reps = (int)($_POST['reps'] ?? 0);
            $sets = (int)($_POST['sets'] ?? 0);
            $date = $_POST['workout_date'] ?? date('Y-m-d');
            $description = htmlspecialchars($_POST['description'] ?? '');

            $uploadedImages = $this->processImageUploads(); 

            if (empty($uploadedImages)) {
                $uploadedImages = json_decode($workout['images'] ?? '[]', true);
            }

            $isUpdated = $workoutModel->update(
                $id, $exercise, $muscle, $weight, $reps, $sets, $date, $description, $uploadedImages, $userId
            );

            if ($isUpdated) {
                $this->addSuccessMessage('TRÉNINK BYL ÚSPĚŠNĚ AKTUALIZOVÁN.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                $this->addErrorMessage('NASTALA CHYBA PŘI UKLÁDÁNÍ.');
            }
            
        } else {
            $this->addNoticeMessage('PRO ÚPRAVU JE NUTNÉ ODESLAT FORMULÁŘ.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }
    }

    // 7. SMAZÁNÍ VÝKONU
    public function delete($id = null) {
    if (!isset($_SESSION['user_id'])) {
        $this->addErrorMessage('PRO SMAZÁNÍ SE MUSÍTE PŘIHLÁSIT.');
        header('Location: ' . BASE_URL . '/index.php?url=auth/login');
        exit;
    }

    if (!$id) {
        $this->addErrorMessage('CHYBÍ ID ZÁZNAMU.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    require_once '../app/models/Database.php';
    require_once '../app/models/Workout.php';
    require_once '../app/models/User.php'; // PŘIDÁNO: Potřebujeme zjistit roli

    $database = new Database();
    $db = $database->getConnection();
    $workoutModel = new Workout($db);

    $workout = $workoutModel->getById($id);

    if (!$workout) {
        $this->addErrorMessage('ZÁZNAM NEBYL NALEZEN.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // 🛡️ ZJIŠTĚNÍ ROLE AKTUÁLNÍHO UŽIVATELE
    $userModel = new User($db);
    $currentUser = $userModel->findById($_SESSION['user_id']);
    $isAdmin = ($currentUser && $currentUser['role'] === 'admin');

    // 🛡️ KONTROLA OPRÁVNĚNÍ (Majitel NEBO Admin)
    if ($workout['created_by'] !== $_SESSION['user_id'] && !$isAdmin) {
        $this->addErrorMessage('NEMÁTE OPRÁVNĚNÍ SMAZAT TENTO ZÁZNAM.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    $isDeleted = $workoutModel->delete($id);

    if ($isDeleted) {
        $this->addSuccessMessage('ZÁZNAM BYL TRVALE ODSTRANĚN.');
    } else {
        $this->addErrorMessage('NASTALA CHYBA PŘI MAZÁNÍ.');
    }

    header('Location: ' . BASE_URL . '/index.php');
    exit;
}

    // --- POMOCNÉ METODY ---

    protected function addSuccessMessage($message) {
        $_SESSION['messages']['success'][] = $message;
    }

     protected function addNoticeMessage($message) {
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
    public function stats() {
    require_once '../app/models/Database.php';
    require_once '../app/models/Workout.php';

    $database = new Database();
    $db = $database->getConnection();

    $workoutModel = new Workout($db);
    $statsData = $workoutModel->getWeightStats();

    // Připravíme pole pro dny a váhy, které dosadíme do JavaScriptu
    $labels = [];
    $weights = [];

    foreach ($statsData as $row) {
        // Zformátujeme datum na hezčí český formát (DD.MM.)
        $labels[] = date('d.m.', strtotime($row['date']));
        $weights[] = (int)$row['total_weight'];
    }

    // Načteme pohled se statistikami
    require_once '../app/views/workouts/workout_stats.php';
  }
}