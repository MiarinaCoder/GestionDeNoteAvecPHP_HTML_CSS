<?php
require_once "../config/db.php";

$page_title = "Tableau de bord des Rapports";
include_once ROOT_PATH . 'includes/header.php';
?>

<div class="content-header">
    <h3>Statistiques et Rapports</h3>
</div>

<div class="reports-grid">
    <a href="note_entre_2.php" class="report-card">
        <h3>Notes par période</h3>
        <p>Consultez la liste détaillée des notes obtenues par les étudiants entre deux dates spécifiques.</p>
    </a>

    <a href="non_soutenu.php" class="report-card">
        <h3>Étudiants en attente</h3>
        <p>Affichez la liste des étudiants qui n'ont pas encore effectué leur soutenance à ce jour.</p>
    </a>
</div>

<?php include_once ROOT_PATH . 'includes/footer.php'; ?>