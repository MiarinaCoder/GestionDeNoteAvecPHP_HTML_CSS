<?php
require_once "../config/db.php";

$page_title = "Modifier un étudiant";

// On récupère le id dans le lien
$matricule_url = $_GET['matricule'] ?? '';

if (isset($_POST['button'])) {
    $matricule = $_POST['matricule'] ?? '';
    $nom_et = $_POST['nom_et'] ?? '';
    $prenoms_et = $_POST['prenoms_et'] ?? '';
    $niveau = $_POST['niveau'] ?? '';
    $parcours = $_POST['parcours'] ?? '';
    $adr_mail = $_POST['adr_mail'] ?? '';

    if (!empty($matricule) && !empty($nom_et) && !empty($niveau) && !empty($parcours) && !empty($adr_mail)) {
        $stmt = mysqli_prepare($conn, "UPDATE etudiant SET matricule=?, nom_et=?, prenoms_et=?, niveau=?, parcours=?, adr_mail=? WHERE matricule=?");
        mysqli_stmt_bind_param($stmt, "sssssss", $matricule, $nom_et, $prenoms_et, $niveau, $parcours, $adr_mail, $matricule_url);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php");
            exit();
        } else {
            $message = "Étudiant non modifié : " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        $message = "Veuillez remplir tous les champs obligatoires !";
    }
}

// Afficher les info concernant un etudiant
$stmt = mysqli_prepare($conn, "SELECT * FROM etudiant WHERE matricule=?");
mysqli_stmt_bind_param($stmt, "s", $matricule_url);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$row) {
    die("Étudiant non trouvé.");
}

include_once ROOT_PATH . 'includes/header.php';
?>

<div class="form-container">
    <a href="index.php" class="btn_back"><img src="<?php echo BASE_URL; ?>assets/images/retour.png" alt="Retour" width="30" height="30"></a>
    <h2>Modifier un étudiant</h2>
    
    <?php if (isset($message)): ?>
        <p class="erreur_message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="?matricule=<?php echo urlencode($matricule_url); ?>" method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label for="matricule">Matricule</label>
                <input type="text" id="matricule" name="matricule" value="<?php echo htmlspecialchars($row['matricule']); ?>" required>
            </div>
            <div class="form-group">
                <label for="nom_et">Nom</label>
                <input type="text" id="nom_et" name="nom_et" value="<?php echo htmlspecialchars($row['nom_et']); ?>" required>
            </div>
            <div class="form-group">
                <label for="prenoms_et">Prénoms</label>
                <input type="text" id="prenoms_et" name="prenoms_et" value="<?php echo htmlspecialchars($row['prenoms_et']); ?>">
            </div>
            <div class="form-group">
                <label for="adr_mail">Email</label>
                <input type="email" id="adr_mail" name="adr_mail" value="<?php echo htmlspecialchars($row['adr_mail']); ?>" required>
            </div>
            <div class="form-group">
                <label for="niveau">Niveau</label>
                <select name="niveau" id="niveau" required>
                    <option value="L1" <?php echo $row['niveau'] == 'L1' ? 'selected' : '' ?>>L1</option>
                    <option value="L2" <?php echo $row['niveau'] == 'L2' ? 'selected' : '' ?>>L2</option>
                    <option value="L3" <?php echo $row['niveau'] == 'L3' ? 'selected' : '' ?>>L3</option>
                    <option value="M1" <?php echo $row['niveau'] == 'M1' ? 'selected' : '' ?>>M1</option>
                    <option value="M2" <?php echo $row['niveau'] == 'M2' ? 'selected' : '' ?>>M2</option>
                </select>
            </div>
            <div class="form-group">
                <label for="parcours">Parcours</label>
                <select name="parcours" id="parcours" required>
                    <option value="GB" <?php echo $row['parcours'] == 'GB' ? 'selected' : '' ?>>GB</option>
                    <option value="SR" <?php echo $row['parcours'] == 'SR' ? 'selected' : '' ?>>SR</option>
                    <option value="IG" <?php echo $row['parcours'] == 'IG' ? 'selected' : '' ?>>IG</option>
                </select>
            </div>
            <div class="form-group full-width">
                <input type="submit" value="Enregistrer les modifications" name="button">
            </div>
        </div>
    </form>
</div>

<?php include_once ROOT_PATH . 'includes/footer.php'; ?>