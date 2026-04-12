<?php
// 1. Nastartování session – bez toho nebudou fungovat tvoje limetkové hlášky o úspěchu
session_start();

// 2. Ladění chyb – nepostradatelné při vývoji (ukáže ti to "střeva" chyby, když něco klekne)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 3. Dynamické zjištění základní adresy (BASE_URL)
// Tato konstanta zajistí, že tvoje styly a obrázky budou mít vždy správnou cestu
$baseDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
// Odstraníme případné lomítko na konci pro čistší spojování cest
$baseDir = rtrim($baseDir, '/'); 
define('BASE_URL', $baseDir);

// 4. Načtení jádra aplikace
// Tento soubor už máš v core/App.php – stará se o routování URL
require_once '../core/App.php';

// 5. Startujeme motor IRON LOGu
$app = new App(); 