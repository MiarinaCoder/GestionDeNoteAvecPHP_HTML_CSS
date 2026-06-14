<?php
require_once "../config/db.php";

$page_title = "Modifier un organisme";

// On récupère le id dans le lien
$idorg_url = $_GET['idorg'] ?? '';

if (isset($_POST['button'])) {
    $idorg = $_POST['idorg'] ?? '';
    $design = $_POST['design'] ?? '';
    $lieu = $_POST['lieu'] ?? '';

    if (!empty($idorg) && !empty($design) && !empty($lieu)) {
        $stmt = mysqli_prepare($conn, "UPDATE organisme SET idorg=?, design=?, lieu=? WHERE idorg=?");
        mysqli_stmt_bind_param($stmt, "issi", $idorg, $design, $lieu, $idorg_url);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php");
            exit();
        } else {
            $message = "Organisme non modifié : " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        $message = "Veuillez remplir tous les champs !";
    }
}

// Afficher les info concernant un organisme
$stmt = mysqli_prepare($conn, "SELECT * FROM organisme WHERE idorg=?");
mysqli_stmt_bind_param($stmt, "i", $idorg_url);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$row) {
    die("Organisme non trouvé.");
}

include_once ROOT_PATH . 'includes/header.php';
?>

<div class="form-container">
    <a href="index.php" class="btn_back"><img src="<?php echo BASE_URL; ?>assets/images/retour.png" alt="Retour" width="30" height="30"></a>
    <h2>Modifier un organisme</h2>
    
    <?php if (isset($message)): ?>
        <p class="erreur_message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="?idorg=<?php echo urlencode($idorg_url); ?>" method="POST">
        <div class="form-group">
            <label for="idorg">ID Organisme</label>
            <input type="text" id="idorg" name="idorg" value="<?php echo htmlspecialchars($row['idorg']); ?>" required>
        </div>
        <div class="form-group">
            <label for="design">Désignation</label>
            <input type="text" id="design" name="design" value="<?php echo htmlspecialchars($row['design']); ?>" required>
        </div>
        <div class="form-group">
            <label for="lieu">Lieu</label>
            <input type="text" id="lieu" name="lieu" value="<?php echo htmlspecialchars($row['lieu']); ?>" required>
        </div>
        <input type="submit" value="Enregistrer les modifications" name="button">
    </form>
</div>

<?php include_once ROOT_PATH . 'includes/footer.php'; ?>
