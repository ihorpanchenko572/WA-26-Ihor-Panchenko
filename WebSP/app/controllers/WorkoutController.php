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
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('PRO PŘIDÁNÍ VÝKONU SE MUSÍTE NEJPRVE PŘIHLÁSIT.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }
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
            $muscle = htmlspecialchars($_POST['muscle_group'] ?? '');
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

        $database = new Database();
        $db = $database->getConnection();

        $workoutModel = new Workout($db);
        $workout = $workoutModel->getById($id);

        if (!$workout) {
            $this->addErrorMessage('ZÁZNAM NENALEZEN.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // 🛡️ OPRAVENO: Kontrola vlastnictví přes created_by
        if ($workout['created_by'] !== $_SESSION['user_id']) {
            $this->addErrorMessage('NEMÁTE OPRÁVNĚNÍ UPRAVOVAT TENTO VÝKON.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

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

            // Získání ID přihlášeného uživatele
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
            $muscle = htmlspecialchars($_POST['muscle_group'] ?? '');
            $weight = (float)($_POST['weight'] ?? 0);
            $reps = (int)($_POST['reps'] ?? 0);
            $sets = (int)($_POST['sets'] ?? 0);
            $date = $_POST['workout_date'] ?? date('Y-m-d');
            $description = htmlspecialchars($_POST['description'] ?? '');

            $uploadedImages = $this->processImageUploads(); 

            if (empty($uploadedImages)) {
                $uploadedImages = json_decode($workout['images'] ?? '[]', true);
            }

            // !!! ZMĚNA: Přidáváme $userId jako poslední argument
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

        $database = new Database();
        $db = $database->getConnection();
        $workoutModel = new Workout($db);

        $workout = $workoutModel->getById($id);

        if (!$workout) {
            $this->addErrorMessage('ZÁZNAM NEBYL NALEZEN.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // 🛡️ OPRAVENO: Kontrola vlastnictví přes created_by
        if ($workout['created_by'] !== $_SESSION['user_id']) {
            $this->addErrorMessage('NEMÁTE OPRÁVNĚNÍ SMAZAT TENTO ZÁZNAM.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        $isDeleted = $workoutModel->delete($id);

        if ($isDeleted) {
            $this->addSuccessMessage('VÁŠ VÝKON BYL TRVALE SMAZÁN.');
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
}