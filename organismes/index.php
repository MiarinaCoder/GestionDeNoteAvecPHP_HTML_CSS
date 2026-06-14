<?php
require_once "../config/db.php";

$page_title = "Liste des Organismes";
$show_search = true;
$search_type = 'organisme';

$query_str = "SELECT * FROM organisme WHERE 1=1";
$params = [];
$types = "";

if (!empty($_POST['recherche'])) {
    $search = trim($_POST['recherche']);
    $query_str .= " AND (idorg LIKE ? OR design LIKE ? OR lieu LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "sss";
}

$query_str .= " ORDER BY idorg ASC";

$stmt = mysqli_prepare($conn, $query_str);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result_query = mysqli_stmt_get_result($stmt);

include_once ROOT_PATH . 'includes/header.php';
?>

<div class="content-header">
    <h3>Organismes</h3>
    <a href="ajouter.php" class="Btn_add">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Nouveau
    </a>
</div>

<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>ID Org</th>
                <th>Désignation</th>
                <th>Lieu</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result_query) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result_query)): ?>
                    <tr>
                        <td data-label="ID Org"><strong><?php echo htmlspecialchars($row["idorg"]); ?></strong></td>
                        <td data-label="Désignation"><?php echo htmlspecialchars($row["design"]); ?></td>
                        <td data-label="Lieu"><?php echo htmlspecialchars($row["lieu"]); ?></td>
                        <td data-label="Actions" style="text-align: center;">
                            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <a href="modifier.php?idorg=<?php echo urlencode($row['idorg']); ?>" title="Modifier">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </a>
                                <a href="supprimer.php?idorg=<?php echo urlencode($row['idorg']); ?>" 
                                   onclick="return confirm('Voulez-vous vraiment supprimer cet organisme ?')" title="Supprimer">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 4rem;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; opacity: 0.5;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        <p style="color: var(--text-muted); font-weight: 500;">Aucun organisme trouvé.</p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="stats">
    <span>Total :</span>
    <input type="text" value="<?php echo mysqli_num_rows($result_query); ?>" readonly>
    <span>organismes enregistrés</span>
</div>

<?php include_once ROOT_PATH . 'includes/footer.php'; ?>