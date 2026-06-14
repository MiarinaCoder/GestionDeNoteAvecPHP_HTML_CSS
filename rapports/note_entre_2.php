<?php
require_once "../config/db.php";

$page_title = "Notes entre deux dates";

$date1 = $_POST['date1'] ?? '';
$date2 = $_POST['date2'] ?? '';
$is_search = isset($_POST['recherche']);

if ($is_search && !empty($date1) && !empty($date2)) {
    $sql = "SELECT Annee_univ, etudiant.matricule, nom_et, prenoms_et, note, date_soute 
            FROM soutenir, etudiant 
            WHERE (etudiant.matricule = soutenir.matricule) AND (date_soute BETWEEN ? AND ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $date1, $date2);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);
} else {
    $sql = "SELECT Annee_univ, etudiant.matricule, nom_et, prenoms_et, note, date_soute 
            FROM etudiant, soutenir 
            WHERE soutenir.matricule = etudiant.matricule ORDER BY Annee_univ";
    $query = mysqli_query($conn, $sql);
}

include_once ROOT_PATH . 'includes/header.php';
?>

<div class="content-header">
    <a href="note.php" class="btn_back"><img src="<?php echo BASE_URL; ?>assets/images/retour.png" alt="Retour" width="30" height="30"></a>
    <h3>Liste des notes des étudiants entre deux dates</h3>
</div>

<div class="form-container" style="max-width: 800px; margin-bottom: 2rem;">
    <form action="" method="post" style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
        <div class="form-group" style="flex: 1; min-width: 200px;">
            <label>Date de début</label>
            <input type="date" name="date1" value="<?php echo htmlspecialchars($date1); ?>" required>
        </div>
        <div class="form-group" style="flex: 1; min-width: 200px;">
            <label>Date de fin</label>
            <input type="date" name="date2" value="<?php echo htmlspecialchars($date2); ?>" required>
        </div>
        <div style="flex: 0 0 auto;">
            <input type="submit" value="Filtrer" name="recherche" style="margin-top: 0; padding: 0.8rem 2rem;">
        </div>
    </form>
</div>

<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>Année Univ</th>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénoms</th>
                <th>Note</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($query) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["Annee_univ"]); ?></td>
                        <td><?php echo htmlspecialchars($row["matricule"]); ?></td>
                        <td><?php echo htmlspecialchars($row["nom_et"]); ?></td>
                        <td><?php echo htmlspecialchars($row["prenoms_et"]); ?></td>
                        <td><?php echo htmlspecialchars($row["note"]); ?></td>
                        <td><?php echo htmlspecialchars($row["date_soute"]); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Aucun résultat trouvé</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include_once ROOT_PATH . 'includes/footer.php'; ?>