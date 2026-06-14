<?php
require_once "../config/db.php";

$page_title = "Modifier un professeur";

// On récupère le id dans le lien
$idprof_url = $_GET['idprof'] ?? '';

if (isset($_POST['button'])) {
    $idprof = $_POST['idprof'] ?? '';
    $nom_prof = $_POST['nom_prof'] ?? '';
    $prenoms_prof = $_POST['prenoms_prof'] ?? '';
    $civilite = $_POST['civilite'] ?? '';
    $grade = $_POST['grade'] ?? '';

    if (!empty($idprof) && !empty($nom_prof) && !empty($prenoms_prof) && !empty($civilite) && !empty($grade)) {
        $stmt = mysqli_prepare($conn, "UPDATE professeur SET idprof=?, nom_prof=?, prenoms_prof=?, civilite=?, grade=? WHERE idprof=?");
        mysqli_stmt_bind_param($stmt, "ssssss", $idprof, $nom_prof, $prenoms_prof, $civilite, $grade, $idprof_url);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php");
            exit();
        } else {
            $message = "Professeur non modifié : " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        $message = "Veuillez remplir tous les champs !";
    }
}

// Afficher les info concernant un professeur
$stmt = mysqli_prepare($conn, "SELECT * FROM professeur WHERE idprof=?");
mysqli_stmt_bind_param($stmt, "s", $idprof_url);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$row) {
    die("Professeur non trouvé.");
}

include_once ROOT_PATH . 'includes/header.php';
?>

<div class="form-container">
    <a href="index.php" class="btn_back"><img src="<?php echo BASE_URL; ?>assets/images/retour.png" alt="Retour" width="30" height="30"></a>
    <h2>Modifier un professeur</h2>
    
    <?php if (isset($message)): ?>
        <p class="erreur_message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="?idprof=<?php echo urlencode($idprof_url); ?>" method="POST">
        <div class="form-group">
            <label for="idprof">ID Professeur</label>
            <input type="text" id="idprof" name="idprof" value="<?php echo htmlspecialchars($row['idprof']); ?>" required>
        </div>
        <div class="form-group">
            <label for="nom_prof">Nom</label>
            <input type="text" id="nom_prof" name="nom_prof" value="<?php echo htmlspecialchars($row['nom_prof']); ?>" required>
        </div>
        <div class="form-group">
            <label for="prenoms_prof">Prénoms</label>
            <input type="text" id="prenoms_prof" name="prenoms_prof" value="<?php echo htmlspecialchars($row['prenoms_prof']); ?>" required>
        </div>
        <div class="form-group">
            <label for="civilite">Civilité</label>
            <select name="civilite" id="civilite" required>
                <option value="madame" <?php echo strtolower($row['civilite']) == 'madame' ? 'selected' : '' ?>>Madame</option>
                <option value="monsieur" <?php echo strtolower($row['civilite']) == 'monsieur' ? 'selected' : '' ?>>Monsieur</option>
                <option value="mademoiselle" <?php echo strtolower($row['civilite']) == 'mademoiselle' ? 'selected' : '' ?>>Mademoiselle</option>
            </select>
        </div>
        <div class="form-group">
            <label for="grade">Grade</label>
            <select name="grade" id="grade" required>
                <option value="Professeur tutilaire" <?php echo $row['grade'] == 'Professeur tutilaire' ? 'selected' : '' ?>>Professeur tutilaire</option>
                <option value="Professeur" <?php echo $row['grade'] == 'Professeur' ? 'selected' : '' ?>>Professeur</option>
                <option value="Maitre de Conference" <?php echo $row['grade'] == 'Maitre de Conference' ? 'selected' : '' ?>>Maitre de Conference</option>
                <option value="Assistant d Enseignement Superieur et de Recherche" <?php echo $row['grade'] == 'Assistant d Enseignement Superieur et de Recherche' ? 'selected' : '' ?>>Assistant d'Enseignement Supérieur et de Recherche</option>
                <option value="Docteur HDR" <?php echo $row['grade'] == 'Docteur HDR' ? 'selected' : '' ?>>Docteur HDR</option>
                <option value="Docteur en Informatique" <?php echo $row['grade'] == 'Docteur en Informatique' ? 'selected' : '' ?>>Docteur en Informatique</option>
                <option value="Doctorant en Informatique" <?php echo $row['grade'] == 'Doctorant en Informatique' ? 'selected' : '' ?>>Doctorant en Informatique</option>
            </select>
        </div>
        <input type="submit" value="Enregistrer les modifications" name="button">
    </form>
</div>

<?php include_once ROOT_PATH . 'includes/footer.php'; ?>
