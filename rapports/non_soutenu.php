<?php
require_once "../config/db.php";

$page_title = "Étudiants n'ayant pas encore soutenu";
include_once ROOT_PATH . 'includes/header.php';

$query_et = mysqli_query($conn, "SELECT etudiant.matricule, nom_et, prenoms_et, niveau, parcours, adr_mail 
FROM etudiant LEFT OUTER JOIN soutenir ON soutenir.matricule = etudiant.matricule WHERE note IS NULL");
?>

<div class="content-header">
    <a href="note.php" class="btn_back"><img src="<?php echo BASE_URL; ?>assets/images/retour.png" alt="Retour" width="30" height="30"></a>
    <h3>Liste des étudiants qui n’ont pas encore effectué de soutenance</h3>
</div>

<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénoms</th>
                <th>Niveau</th>
                <th>Parcours</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($query_et) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($query_et)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["matricule"]); ?></td>
                        <td><?php echo htmlspecialchars($row["nom_et"]); ?></td>
                        <td><?php echo htmlspecialchars($row["prenoms_et"]); ?></td>
                        <td><?php echo htmlspecialchars($row["niveau"]); ?></td>
                        <td><?php echo htmlspecialchars($row["parcours"]); ?></td>
                        <td><?php echo htmlspecialchars($row["adr_mail"]); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Aucun étudiant trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include_once ROOT_PATH . 'includes/footer.php'; ?>