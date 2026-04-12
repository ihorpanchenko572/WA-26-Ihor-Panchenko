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
        require_once '../app/views/workouts/workout_create.php';
    }

    // 4. ULOŽENÍ NOVÉHO TRÉNINKU
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
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
            $isSaved = $workoutModel->create($exercise, $muscle, $weight, $reps, $sets, $date, $description, $uploadedImages);

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

        require_once '../app/views/workouts/workout_edit.php';
    }

    // 6. AKTUALIZACE STÁVAJÍCÍHO ZÁZNAMU
    public function update($id = null) {
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
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

        // Zpracování obrázků
        $uploadedImages = $this->processImageUploads(); 

        require_once '../app/models/Database.php';
        require_once '../app/models/Workout.php';

        $database = new Database();
        $db = $database->getConnection();
        $workoutModel = new Workout($db);

        // --- ZÁCHRANNÁ BRZDA PRO OBRÁZKY ---
        if (empty($uploadedImages)) {
            $currentData = $workoutModel->getById($id);
            $uploadedImages = json_decode($currentData['images'] ?? '[]', true);
        }

        $isUpdated = $workoutModel->update($id, $exercise, $muscle, $weight, $reps, $sets, $date, $description, $uploadedImages);

        if ($isUpdated) {
            $this->addSuccessMessage('ZÁZNAM AKTUALIZOVÁN.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        } else {
            $this->addErrorMessage('AKTUALIZACE SELHALA.');
        }
    }

    // 7. SMAZÁNÍ VÝKONU
    public function delete($id = null) {
        if (!$id) {
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Workout.php';

        $database = new Database();
        $db = $database->getConnection();

        $workoutModel = new Workout($db);
        if ($workoutModel->delete($id)) {
            $this->addSuccessMessage('VÝKON SMAZÁN.');
        } else {
            $this->addErrorMessage('CHYBA PŘI MAZÁNÍ.');
        }

        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // --- POMOCNÉ METODY ---

    protected function addSuccessMessage($message) {
        $_SESSION['messages']['success'][] = $message;
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