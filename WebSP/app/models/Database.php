<?php

class Database {
    private $host = "localhost";
    private $db_name = "iron_log_db"; // Název tvé nové fitness databáze
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        
        // Odpojí předchozí připojení pro čistý start
        $this->conn = null;
        
        try {
            // Připojení pomocí PDO k iron_log_db
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            
            // Nastavení kódování, aby ti fungovala čeština v názvech cviků
            $this->conn->exec("set names utf8mb4");
            
            // Zapnutí vyhazování výjimek při SQL chybách
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Výpis informace o úspěšném připojení (pro testování)
            // Až ti vše pojede, můžeš tenhle řádek zakomentovat
            echo "NAPOJENO NA ŽELEZO (iron_log_db OK)!<br>";
            
        } catch (PDOException $exception) {
            echo "Chyba připojení k fitness databázi: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

// --- TESTOVACÍ BLOK (stejný jako ve škole) ---
// Po spuštění souboru v prohlížeči hned uvidíš, jestli ses trefil do hesla a názvu DB.
$database = new Database();
$database->getConnection();