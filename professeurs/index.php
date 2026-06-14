<?php
require_once "../config/db.php";

$page_title = "Liste des Professeurs";
$show_search = true;
$search_type = 'professeur';

$query_str = "SELECT * FROM professeur WHERE 1=1";
$params = [];
$types = "";

if (!empty($_POST['recherche'])) {
    $search = trim($_POST['recherche']);
    $query_str .= " AND (idprof LIKE ? OR Nom_prof LIKE ? OR Prenoms_prof LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "sss";
}

$query_str .= " ORDER BY idprof ASC";

$stmt = mysqli_prepare($conn, $query_str);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result_query = mysqli_stmt_get_result($stmt);

include_once ROOT_PATH . 'includes/header.php';
?>

<div class="content-header">
    <h3>Professeurs</h3>
    <a href="ajouter.php" class="Btn_add">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Nouveau
    </a>
</div>

<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>ID Prof</th>
                <th>Nom & Prénoms</th>
                <th>Civilité</th>
                <th>Grade</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result_query) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result_query)): ?>
                    <tr>
                        <td data-label="ID Prof"><strong><?php echo htmlspecialchars($row["idprof"]); ?></strong></td>
                        <td data-label="Nom & Prénoms">
                            <div style="font-weight: 700; color: var(--text-main);"><?php echo htmlspecialchars($row["nom_prof"]); ?></div>
                            <div style="font-size: 0.85rem; color: var(--text-muted);"><?php echo htmlspecialchars($row["prenoms_prof"]); ?></div>
                        </td>
                        <td data-label="Civilité"><?php echo htmlspecialchars($row["civilite"]); ?></td>
                        <td data-label="Grade"><span class="badge"><?php echo htmlspecialchars($row["grade"]); ?></span></td>
                        <td data-label="Actions" style="text-align: center;">
                            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <a href="modifier.php?idprof=<?php echo urlencode($row['idprof']); ?>" title="Modifier">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </a>
                                <a href="supprimer.php?idprof=<?php echo urlencode($row['idprof']); ?>" 
                                   onclick="return confirm('Voulez-vous vraiment supprimer ce professeur ?')" title="Supprimer">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 4rem;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; opacity: 0.5;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        <p style="color: var(--text-muted); font-weight: 500;">Aucun professeur trouvé.</p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="stats">
    <span>Total :</span>
    <input type="text" value="<?php echo mysqli_num_rows($result_query); ?>" readonly>
    <span>professeurs enregistrés</span>
</div>

<?php include_once ROOT_PATH . 'includes/footer.php'; ?>