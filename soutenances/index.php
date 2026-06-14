<?php
require_once "../config/db.php";

$page_title = "Liste des Soutenances";
$show_search = true;
$search_type = 'soutenance';

$query_str = "SELECT * FROM soutenir WHERE 1=1";
$params = [];
$types = "";

if (!empty($_POST['recherche'])) {
    $search = trim($_POST['recherche']);
    $query_str .= " AND (matricule LIKE ? OR idorg LIKE ? OR Annee_univ LIKE ? OR president LIKE ? OR examinateur LIKE ? OR rapporteur_int LIKE ? OR rapporteur_ext LIKE ?)";
    $search_param = "%$search%";
    for ($i = 0; $i < 7; $i++) {
        $params[] = $search_param;
        $types .= "s";
    }
}

$query_str .= " ORDER BY Annee_univ ASC";

$stmt = mysqli_prepare($conn, $query_str);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result_query = mysqli_stmt_get_result($stmt);

include_once ROOT_PATH . 'includes/header.php';
?>

<div class="content-header">
    <h3>Soutenances</h3>
    <a href="ajouter.php" class="Btn_add">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Nouveau
    </a>
</div>

<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>Étudiant</th>
                <th>Organisme</th>
                <th>Année Univ</th>
                <th>Note</th>
                <th>Jury</th>
                <th style="text-align: center;">Actions</th>
                <th>Rapport</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result_query) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result_query)): ?>
                    <tr>
                        <td data-label="Étudiant"><strong><?php echo htmlspecialchars($row["matricule"]); ?></strong></td>
                        <td data-label="Organisme"><?php echo htmlspecialchars($row["idorg"]); ?></td>
                        <td data-label="Année Univ"><?php echo htmlspecialchars($row["Annee_univ"]); ?></td>
                        <td data-label="Note"><span class="badge" style="background: var(--primary); color: white;"><?php echo htmlspecialchars($row["note"]); ?></span></td>
                        <td data-label="Jury" style="font-size: 0.85rem;">
                            <div><span style="color: var(--text-muted);">P:</span> <?php echo htmlspecialchars($row["president"]); ?></div>
                            <div><span style="color: var(--text-muted);">E:</span> <?php echo htmlspecialchars($row["examinateur"]); ?></div>
                        </td>
                        <td data-label="Actions" style="text-align: center;">
                            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <a href="modifier.php?matricule=<?php echo urlencode($row['matricule']); ?>" title="Modifier">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </a>
                                <a href="supprimer.php?matricule=<?php echo urlencode($row['matricule']); ?>" 
                                   onclick="return confirm('Voulez-vous vraiment supprimer cette soutenance ?')" title="Supprimer">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </a>
                            </div>
                        </td>
                        <td data-label="Rapport">
                            <a href="<?php echo BASE_URL; ?>rapports/genPDF.php?matricule=<?php echo urlencode($row['matricule']); ?>" class="badge" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                PV PDF
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 4rem;">
                        <p style="color: var(--text-muted); font-weight: 500;">Aucune soutenance trouvée.</p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include_once ROOT_PATH . 'includes/footer.php'; ?>