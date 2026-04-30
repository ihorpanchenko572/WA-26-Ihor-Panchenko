<?php

class BookController {

    // 0. Výchozí metoda pro zobrazení úvodní stránky
        public function index() {
        // Načtení potřebných tříd
        require_once '../app/models/Database.php';
        require_once '../app/models/Book.php';

        // Vytvoření připojení k databázi
        $database = new Database();
        $db = $database->getConnection();

        // Inicializace modelu a získání dat
        $bookModel = new Book($db);
        $books = $bookModel->getAll(); // Proměnná $books nyní obsahuje pole všech knih
        
        // Načte se (vloží) připravený soubor s HTML strukturou
        require_once '../app/views/books/books_list.php';
    }

    // Zobrazení detailu jedné konkrétní knihy
    public function show($id = null) {
        // 1. Kontrola, zda bylo v URL předáno ID
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID knihy pro zobrazení detailu.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // 2. Načtení potřebných tříd a spojení s databází
        require_once '../app/models/Database.php';
        require_once '../app/models/Book.php';

        $database = new Database();
        $db = $database->getConnection();

        // 3. Získání dat o knize pomocí modelu
        $bookModel = new Book($db);
        $book = $bookModel->getById($id);

        // 4. Kontrola, zda kniha existuje
        if (!$book) {
            $this->addErrorMessage('Požadovaná kniha nebyla nalezena.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // 5. Načtení pohledu pro detail knihy
        require_once '../app/views/books/book_show.php';
    }


    // 1. Zobrazení formuláře pro přidání nové knihy
    // Zobrazení formuláře pro přidání knihy
    public function create() {
        // Kontrola přihlášení
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro přidání knihy se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        // Načtení databáze a modelu Category
        require_once '../app/models/Database.php';
        require_once '../app/models/Category.php';

        $database = new Database();
        $db = $database->getConnection();

        // Inicializace modelu Category
        $categoryModel = new Category($db);

        // Získání seznamu hlavních kategorií
        $categories = $categoryModel->getAllCategories();

        // Získání seznamu všech podkategorií (aby se daly vypsat v druhém selectu)
        $subcategories = $categoryModel->getAllSubcategories();

        // V šabloně book_create.php nyní budeme mít k dispozici pole $categories a $subcategories
        require_once '../app/views/books/book_create.php';
    }

       // 2. Zpracování dat odeslaných z formuláře
    public function store() {
        // Kontrola, zda byl formulář odeslán metodou POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // !!! ZMĚNA: ZDE PŘIDÁME KONTROLU PŘIHLÁŠENÍ ---
            if (!isset($_SESSION['user_id'])) {
                $this->addErrorMessage('Pro uložení knihy musíte být přihlášeni.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }
            $userId = $_SESSION['user_id'];
            // ---------------------------------------
            
            // 1. Získání a očištění textových dat (ochrana proti XSS)
            $title = htmlspecialchars($_POST['title'] ?? '');
            $author = htmlspecialchars($_POST['author'] ?? '');
            $isbn = htmlspecialchars($_POST['isbn'] ?? '');
            // $category = htmlspecialchars($_POST['category'] ?? '');
                 // 🛡️ ZMĚNA: Kategorie k nám nyní chodí jako číslo (ID z value atributu selectu)
            $category = (int)($_POST['category'] ?? 0);
            //$subcategory = htmlspecialchars($_POST['subcategory'] ?? '');
            // 🛡️ ZMĚNA: Kategorie k nám nyní chodí jako číslo (ID z value atributu selectu)
            $subcategory = (int)($_POST['subcategory'] ?? 0);
            
            
            // U číselných hodnot se provádí explicitní přetypování
            $year = (int)($_POST['year'] ?? 0);
            $price = (float)($_POST['price'] ?? 0);
            
            $link = htmlspecialchars($_POST['link'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');

            // Prozatímní zástupce pro obrázky (bude řešeno v budoucnu)
            //$uploadedImages = []; 

            // ZDE JE ZMĚNA: Zavolání metody, která zpracuje soubory v $_FILES
            // Vrátí nám hezké pole s novými názvy (např. ['book_123.jpg', 'book_456.png'])
            $uploadedImages = $this->processImageUploads(); 

            // 2. Komunikace s databází a modelem
            require_once '../app/models/Database.php';
            require_once '../app/models/Book.php';

            // Vytvoření připojení k DB
            $database = new Database();
            $db = $database->getConnection();

            // Vytvoření objektu knihy a volání metody pro uložení
            $bookModel = new Book($db);
            $isSaved = $bookModel->create(
                $title, $author, $category, $subcategory, 
                $year, $price, $isbn, $description, $link, $uploadedImages,
                $userId // PŘEDÁVÁME ID UŽIVATELE
            );

            // 3. Vyhodnocení výsledku a přesměrování
            if ($isSaved) {
                // Vyvolání zelené notifikace pro úspěšnou akci
                $this->addSuccessMessage('Kniha byla úspěšně uložena do databáze.');
                
                // Přesměrování zpět na hlavní stránku s využitím dynamické BASE_URL
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                // Vyvolání červené notifikace pro kritické selhání
                $this->addErrorMessage('Nastala chyba. Nepodařilo se uložit knihu do databáze.');
            }
            
        } else {
            // Pokud je stránka navštívena napřímo bez odeslání dat, zobrazí se žlutá informativní zpráva
            $this->addNoticeMessage('Pro přidání knihy je nutné odeslat formulář.');
        }
    }

    // 3. Smazání existující knihy
    // 3. Smazání existující knihy
public function delete($id = null) {
    // 🔒 ZMĚNA: Kontrola autentizace. 
    // Pouze přihlášený uživatel může iniciovat proces mazání.
    if (!isset($_SESSION['user_id'])) {
        $this->addErrorMessage('Pro smazání knihy se musíte nejprve přihlásit.');
        header('Location: ' . BASE_URL . '/index.php?url=auth/login');
        exit;
    }

    // Kontrola, zda bylo v URL předáno ID
    if (!$id) {
        $this->addErrorMessage('Nebylo zadáno ID knihy ke smazání.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // Načtení potřebných tříd a spojení s databází
    require_once '../app/models/Database.php';
    require_once '../app/models/Book.php';

    $database = new Database();
    $db = $database->getConnection();
    $bookModel = new Book($db);

    // 🛡️ ZMĚNA: Kontrola autorizace (vlastnictví).
    // Nejdříve musíme knihu načíst, abychom zjistili, kdo ji vytvořil.
    $book = $bookModel->getById($id);

    if (!$book) {
        $this->addErrorMessage('Kniha nebyla nalezena, pravděpodobně již byla smazána.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // Ověříme, zda je aktuálně přihlášený uživatel autorem záznamu.
    if ($book['created_by'] !== $_SESSION['user_id']) {
        $this->addErrorMessage('Nemáte oprávnění smazat tuto knihu, protože nejste jejím autorem.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // 🛡️ ZMĚNA: Teprve po úspěšném ověření totožnosti provedeme samotné smazání.
    $isDeleted = $bookModel->delete($id);

    // Vyhodnocení výsledku a přesměrování s notifikací
    if ($isDeleted) {
        $this->addSuccessMessage('Kniha byla trvale smazána z databáze.');
    } else {
        $this->addErrorMessage('Nastala chyba. Knihu se nepodařilo smazat.');
    }

    header('Location: ' . BASE_URL . '/index.php');
    exit;
}

    // 4. Zobrazení formuláře pro úpravu existující knihy
       // 4. Zobrazení formuláře pro úpravu existující knihy
    // 4. Zobrazení formuláře pro úpravu existující knihy
    public function edit($id = null) {
        // 🔒 Kontrola, zda je uživatel přihlášen
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro úpravu knihy se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }
        
        // Kontrola, zda bylo v URL předáno ID
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID knihy k úpravě.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Načtení potřebných tříd a spojení s databází
        require_once '../app/models/Database.php';
        require_once '../app/models/Book.php';
        require_once '../app/models/Category.php';

        $database = new Database();
        $db = $database->getConnection();

        // --- NAČTENÍ KATEGORIÍ PRO FORMULÁŘ ---
        $categoryModel = new Category($db);
        $categories = $categoryModel->getAllCategories();
        $subcategories = $categoryModel->getAllSubcategories(); // Přidáno pro podkategorie

        // Získání dat o konkrétní knize
        $bookModel = new Book($db);
        $book = $bookModel->getById($id);

        // Bezpečnostní kontrola: Zda kniha s daným ID vůbec existuje
        if (!$book) {
            $this->addErrorMessage('Požadovaná kniha nebyla v databázi nalezena.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // 🛡️ Kontrola vlastnictví (Autorizace)
        if ($book['created_by'] !== $_SESSION['user_id']) {
            $this->addErrorMessage('Nemáte oprávnění upravovat tuto knihu, protože nejste jejím autorem.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Načtení pohledu (view) pro editaci
        // Šablona má nyní přístup k $book, $categories a $subcategories
        require_once '../app/views/books/book_edit.php';
    }

    // 5. Zpracování dat odeslaných z editačního formuláře
    // 5. Zpracování dat odeslaných z editačního formuláře
    // 5. Zpracování dat odeslaných z editačního formuláře
    public function update($id = null) {
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID knihy k aktualizaci.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                $this->addErrorMessage('Pro uložení změn se musíte nejprve přihlásit.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }

            // Získání ID aktuálně přihlášeného uživatele ze session
            $userId = $_SESSION['user_id']; 

            require_once '../app/models/Database.php';
            require_once '../app/models/Book.php';

            $database = new Database();
            $db = $database->getConnection();
            $bookModel = new Book($db);

            $book = $bookModel->getById($id);

            if (!$book || $book['created_by'] !== $_SESSION['user_id']) {
                $this->addErrorMessage('Nemáte oprávnění ukládat změny u této knihy.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            }

            $title = htmlspecialchars($_POST['title'] ?? '');
            $author = htmlspecialchars($_POST['author'] ?? '');
            $isbn = htmlspecialchars($_POST['isbn'] ?? '');
            // $category = htmlspecialchars($_POST['category'] ?? '');
                 // 🛡️ ZMĚNA: Kategorie k nám nyní chodí jako číslo (ID z value atributu selectu)
            $category = (int)($_POST['category'] ?? 0);
            //$subcategory = htmlspecialchars($_POST['subcategory'] ?? '');
            // 🛡️ ZMĚNA: Kategorie k nám nyní chodí jako číslo (ID z value atributu selectu)
            $subcategory = (int)($_POST['subcategory'] ?? 0);
            
            $year = (int)($_POST['year'] ?? 0);
            $price = (float)($_POST['price'] ?? 0);
            $link = htmlspecialchars($_POST['link'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');

            $uploadedImages = $this->processImageUploads();

            // !!! ZMĚNA: Přidáváme $userId jako poslední argument
            $isUpdated = $bookModel->update(
                $id, $title, $author, $category, $subcategory, 
                $year, $price, $isbn, $description, $link, $uploadedImages,
                $userId 
            );

            if ($isUpdated) {
                $this->addSuccessMessage('Kniha byla úspěšně upravena.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                $this->addErrorMessage('Nastala chyba. Změny se nepodařilo uložit.');
            }
            
        } else {
            $this->addNoticeMessage('Pro úpravu knihy je nutné odeslat formulář.');
        }
    }

    // --- Pomocné metody pro systém notifikací ---
    // (V reálném projektu by tyto metody ideálně ležely v hlavní nadřazené třídě Controller)

    protected function addSuccessMessage($message) {
        // Zelená zpráva o úspěchu
        $_SESSION['messages']['success'][] = $message;
    }

    protected function addNoticeMessage($message) {
        // Žlutá informativní zpráva
        $_SESSION['messages']['notice'][] = $message;
    }

    protected function addErrorMessage($message) {
        // Červená chybová zpráva
        $_SESSION['messages']['error'][] = $message;
    }

    // --- Pomocná metoda pro zpracování nahrávání obrázků ---
    protected function processImageUploads() {
        $uploadedFiles = [];
        
        // Cesta ke složce, kam se budou obrázky fyzicky ukládat (relativně od index.php)
        $uploadDir = __DIR__ . '/../../public/uploads/'; 
        
        // Zkontrolujeme, zda vůbec existuje adresář, pokud ne, vytvoříme ho
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Zkontrolujeme, zda byl odeslán alespoň jeden soubor
        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $fileCount = count($_FILES['images']['name']);

            for ($i = 0; $i < $fileCount; $i++) {
                // Pokud při nahrávání tohoto konkrétního souboru nedošlo k chybě
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                    
                    $tmpName = $_FILES['images']['tmp_name'][$i];
                    $originalName = basename($_FILES['images']['name'][$i]);
                    // Zjištění koncovky (např. jpg, png)
                    $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

                    // Můžeme zde přidat i kontrolu povolených formátů (volitelné)
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                    if (!in_array($fileExtension, $allowedExtensions)) {
                        continue; // Přeskočíme nepodporovaný soubor
                    }

                    // 1. Vygenerování unikátního jména pomocí aktuálního času a náhodného řetězce
                    // např: book_64a2b1c_8f2a.jpg
                    $newName = 'book_' . uniqid() . '_' . substr(md5(mt_rand()), 0, 4) . '.' . $fileExtension;
                    $targetFilePath = $uploadDir . $newName;

                    // 2. Fyzický přesun souboru z dočasné paměti do naší složky uploads
                    if (move_uploaded_file($tmpName, $targetFilePath)) {
                        // 3. Uložení POUZE NÁZVU do pole, které pak pošleme databázi
                        $uploadedFiles[] = $newName; 
                    }
                }
            }
        }
        return $uploadedFiles;
    }



}