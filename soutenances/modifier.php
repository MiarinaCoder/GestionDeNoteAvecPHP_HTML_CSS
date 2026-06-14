<?php
require_once "../config/db.php";

$page_title = "Modifier une soutenance";

// On récupère le matricule dans le lien
$matricule_url = $_GET['matricule'] ?? '';

if (isset($_POST['button'])) {
    $matricule = $_POST['matricule'] ?? '';
    $idorg = $_POST['idorg'] ?? '';
    $annee_univ = $_POST['annee_univ'] ?? '';
    $note = $_POST['note'] !== '' ? $_POST['note'] : null;
    $president = $_POST['president'] ?? '';
    $examinateur = $_POST['examinateur'] ?? '';
    $rapporteur_int = $_POST['rapporteur_int'] ?? '';
    $rapporteur_ext = $_POST['rapporteur_ext'] ?? '';

    if (!empty($matricule) && !empty($idorg) && !empty($annee_univ) && !empty($president) && !empty($examinateur) && !empty($rapporteur_int)) {
        $stmt = mysqli_prepare($conn, "UPDATE soutenir SET matricule=?, idorg=?, Annee_univ=?, note=?, president=?, examinateur=?, rapporteur_int=?, rapporteur_ext=? WHERE matricule=?");
        mysqli_stmt_bind_param($stmt, "sisssssss", $matricule, $idorg, $annee_univ, $note, $president, $examinateur, $rapporteur_int, $rapporteur_ext, $matricule_url);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php");
            exit();
        } else {
            $message = "Soutenance non modifiée : " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        $message = "Veuillez remplir tous les champs obligatoires !";
    }
}

// Afficher les info concernant la soutenance
$stmt = mysqli_prepare($conn, "SELECT * FROM soutenir WHERE matricule=?");
mysqli_stmt_bind_param($stmt, "s", $matricule_url);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$row) {
    die("Soutenance non trouvée.");
}

include_once ROOT_PATH . 'includes/header.php';
?>

<div class="form-container">
    <a href="index.php" class="btn_back"><img src="<?php echo BASE_URL; ?>assets/images/retour.png" alt="Retour" width="30" height="30"></a>
    <h2>Modifier une soutenance</h2>
    
    <?php if (isset($message)): ?>
        <p class="erreur_message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="?matricule=<?php echo urlencode($matricule_url); ?>" method="POST">
        <div class="form-group">
            <label for="matricule">Matricule</label>
            <input type="text" id="matricule" name="matricule" value="<?php echo htmlspecialchars($row['matricule']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="idorg">ID Organisme</label>
            <input type="text" id="idorg" name="idorg" value="<?php echo htmlspecialchars($row['idorg']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="annee_univ">Année Universitaire</label>
            <input type="text" id="annee_univ" name="annee_univ" value="<?php echo htmlspecialchars($row['Annee_univ']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="note">Note</label>
            <input type="number" step="0.01" id="note" name="note" value="<?php echo htmlspecialchars($row['note']); ?>">
        </div>
        
        <div class="form-group">
            <label for="president">Président</label>
            <input type="text" id="president" name="president" value="<?php echo htmlspecialchars($row['president']); ?>" required>
        </div>

        <div class="form-group">
            <label for="examinateur">Examinateur</label>
            <input type="text" id="examinateur" name="examinateur" value="<?php echo htmlspecialchars($row['examinateur']); ?>" required>
        </div>

        <div class="form-group">
            <label for="rapporteur_int">Rapporteur Interne</label>
            <input type="text" id="rapporteur_int" name="rapporteur_int" value="<?php echo htmlspecialchars($row['rapporteur_int']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="rapporteur_ext">Rapporteur Externe</label>
            <input type="text" id="rapporteur_ext" name="rapporteur_ext" value="<?php echo htmlspecialchars($row['rapporteur_ext']); ?>">
        </div>
        
        <input type="submit" value="Enregistrer les modifications" name="button">
    </form>
</div>

<?php include_once ROOT_PATH . 'includes/footer.php'; ?>
