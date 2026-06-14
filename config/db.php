<?php
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'gestion_soutenance');

// Chemins
define('ROOT_PATH', realpath(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
define('BASE_URL', '/GestionDeNoteAvecPHP_HTML_CSS-main/'); // À ajuster selon le déploiement

/**
 * Initialise la connexion à la base de données
 * @return mysqli|false
 */
function get_db_connection() {
    static $conn = null;
    if ($conn === null) {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (!$conn) {
            die("La connexion à la base de données a échoué : " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8mb4");
    }
    return $conn;
}

// Pour la compatibilité avec l'ancien code
$conn = get_db_connection();
?>