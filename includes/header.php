<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../assets/css/style.css">
    <title><?php echo isset($page_title) ? $page_title : 'Gestion de Soutenance'; ?></title>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon">S</div>
            <div class="logo-text">G.Soutenance</div>
        </div>
        <?php include_once ROOT_PATH . 'includes/nav.php'; ?>
    </aside>

    <div class="main-content">
        <header>
            <div class="search-container">
                <?php if (isset($show_search) && $show_search): ?>
                <form class="rec" role="search" action="" method="POST">
                    <?php if (isset($search_type) && $search_type === 'etudiant'): ?>
                        <div class="search-filters">
                            <select name="niveau">
                                <?php 
                                $sql_niv = "SELECT DISTINCT niveau FROM etudiant UNION SELECT 'Tous les niveaux' AS niveau ORDER BY CASE WHEN niveau='M2' THEN 6 WHEN niveau='M1' THEN 5 WHEN niveau='L3' THEN 4 WHEN niveau='L2' THEN 3 WHEN niveau='L1' THEN 2 ELSE 1 END, niveau";
                                $res_niv = mysqli_query($conn, $sql_niv);
                                while ($niv = mysqli_fetch_assoc($res_niv)) {
                                    $selected = (isset($_POST['niveau']) && $_POST['niveau'] == $niv['niveau']) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($niv['niveau']) . "' $selected>" . htmlspecialchars($niv['niveau']) . "</option>";
                                } 
                                ?>
                            </select>

                            <select name="parcours">
                                <?php 
                                $sql_par = "SELECT DISTINCT parcours FROM etudiant UNION SELECT 'Tous les parcours' AS parcours ORDER BY CASE WHEN parcours='IG' THEN 4 WHEN parcours='SR' THEN 3 WHEN parcours='GB' THEN 2 ELSE 1 END, parcours";
                                $res_par = mysqli_query($conn, $sql_par);
                                while ($par = mysqli_fetch_assoc($res_par)) {
                                    $selected = (isset($_POST['parcours']) && $_POST['parcours'] == $par['parcours']) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($par['parcours']) . "' $selected>" . htmlspecialchars($par['parcours']) . "</option>";
                                } 
                                ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    <input type="search" placeholder="Rechercher quelque chose..." name="recherche" value="<?php echo isset($_POST['recherche']) ? htmlspecialchars($_POST['recherche']) : ''; ?>">
                    <button class="btn_search" type="submit">Rechercher</button>
                </form>
                <?php endif; ?>
            </div>
            
            <div class="header-actions">
                <!-- Placeholder for user profile or notifications in 2026 -->
                <div class="badge">Session Active</div>
            </div>
        </header>
        <main class="container">