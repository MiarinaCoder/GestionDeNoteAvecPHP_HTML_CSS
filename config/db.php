<?php
/**
 * config/db.php
 * Configuration et connexion à la base de données.
 * Supporte les environnements local, Docker, VPS, et hébergement mutualisé.
 */

// ─────────────────────────────────────────────
// 1. Chargement optionnel d'un fichier .env manuel
//    (si pas de variables système disponibles)
// ─────────────────────────────────────────────
$envFile = realpath(dirname(__DIR__)) . DIRECTORY_SEPARATOR . '.env.php';
if (file_exists($envFile)) {
    require_once $envFile;
}

// ─────────────────────────────────────────────
// 2. Détection de l'environnement
// ─────────────────────────────────────────────
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$isLocal = in_array($host, ['localhost', '127.0.0.1', '::1'], true)
        || substr($host, -6) === '.local'
        || substr($host, -5) === '.test';

// ─────────────────────────────────────────────
// 3. Résolution des variables selon l'environnement
// ─────────────────────────────────────────────
if ($isLocal) {
    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '';
    $dbName = 'gestion_soutenance';
} else {
    // trim() retire les espaces ET les guillemets simples éventuels
    $dbHost = trim(getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? ''), " \t\n\r\0\x0B'\"");
    $dbUser = trim(getenv('DB_USER') ?: ($_ENV['DB_USER'] ?? ''), " \t\n\r\0\x0B'\"");
    $dbPass = trim(getenv('DB_PASS') ?: ($_ENV['DB_PASS'] ?? ''), " \t\n\r\0\x0B'\"");
    $dbName = trim(getenv('DB_NAME') ?: ($_ENV['DB_NAME'] ?? ''), " \t\n\r\0\x0B'\"");
}

// ─────────────────────────────────────────────
// 4. Validation des variables avant connexion
// ─────────────────────────────────────────────
$missingVars = [];
if (empty($dbHost)) $missingVars[] = 'DB_HOST';
if (empty($dbUser)) $missingVars[] = 'DB_USER';
if (empty($dbName)) $missingVars[] = 'DB_NAME';

if (!empty($missingVars)) {
    $message = 'Erreur de configuration : les variables d\'environnement suivantes sont manquantes ou vides : '
             . implode(', ', $missingVars)
             . '. Vérifiez votre configuration serveur ou votre fichier .env.php.';
    error_log($message);
    die($message);
}

// ─────────────────────────────────────────────
// 5. Définition des constantes
// ─────────────────────────────────────────────
define('DB_HOST', $dbHost);
define('DB_USER', $dbUser);
define('DB_PASS', $dbPass);
define('DB_NAME', $dbName);

define('ROOT_PATH', realpath(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
define('BASE_URL', '/GestionDeNoteAvecPHP_HTML_CSS/');

// ─────────────────────────────────────────────
// 6. Connexion singleton
// ─────────────────────────────────────────────
function get_db_connection(): mysqli {
    static $conn = null;

    if ($conn === null) {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if (!$conn) {
            $error = 'La connexion à la base de données a échoué : ' . mysqli_connect_error()
                   . ' (errno: ' . mysqli_connect_errno() . ')';
            error_log($error);
            die($error);
        }

        mysqli_set_charset($conn, 'utf8mb4');
    }

    return $conn;
}

// Compatibilité avec l'ancien code utilisant $conn directement
$conn = get_db_connection();
?>