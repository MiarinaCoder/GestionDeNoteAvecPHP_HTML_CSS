<?php
require_once "../config/db.php";

$page_title = "Ajouter un professeur";

if (isset($_POST['button'])) {
    $idprof = $_POST['idprof'] ?? '';
    $nom_prof = $_POST['nom_prof'] ?? '';
    $prenoms_prof = $_POST['prenoms_prof'] ?? '';
    $civilite = $_POST['civilite'] ?? '';
    $grade = $_POST['grade'] ?? '';

    if (!empty($idprof) && !empty($nom_prof) && !empty($prenoms_prof) && !empty($civilite) && !empty($grade)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO professeur (idprof, nom_prof, prenoms_prof, civilite, grade) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssss", $idprof, $nom_prof, $prenoms_prof, $civilite, $grade);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php");
            exit();
        } else {
            $message = "Professeur non ajouté : " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        $message = "Veuillez remplir tous les champs !";
    }
}

include_once ROOT_PATH . 'includes/header.php';
?>

<div class="form-container">
    <a href="index.php" class="btn_back"><img src="<?php echo BASE_URL; ?>assets/images/retour.png" alt="Retour" width="30" height="30"></a>
    <h2>Ajouter un professeur</h2>
    
    <?php if (isset($message)): ?>
        <p class="erreur_message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="" method="post">
        <div class="form-group">
            <label for="idprof">ID Professeur</label>
            <input type="text" id="idprof" name="idprof" required>
        </div>
        <div class="form-group">
            <label for="nom_prof">Nom</label>
            <input type="text" id="nom_prof" name="nom_prof" required>
        </div>
        <div class="form-group">
            <label for="prenoms_prof">Prénoms</label>
            <input type="text" id="prenoms_prof" name="prenoms_prof" required>
        </div>
        <div class="form-group">
            <label for="civilite">Civilité</label>
            <select name="civilite" id="civilite" required>
                <option value="madame">Madame</option>
                <option value="monsieur">Monsieur</option>
                <option value="mademoiselle">Mademoiselle</option>
            </select>
        </div>
        <div class="form-group">
            <label for="grade">Grade</label>
            <select name="grade" id="grade" required>
                <option value="Professeur tutilaire">Professeur tutilaire</option>
                <option value="Professeur">Professeur</option>
                <option value="Maitre de Conference">Maitre de Conference</option>
                <option value="Assistant d Enseignement Superieur et de Recherche">Assistant d Enseignement Superieur et de Recherche</option>
                <option value="Docteur HDR">Docteur HDR</option>
                <option value="Docteur en Informatique">Docteur en Informatique</option>
                <option value="Doctorant en Informatique">Doctorant en Informatique</option>
            </select>
        </div>
        <input type="submit" value="Ajouter" name="button">
    </form>
</div>

<?php include_once ROOT_PATH . 'includes/footer.php'; ?>
