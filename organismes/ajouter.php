<?php
require_once "../config/db.php";

$page_title = "Ajouter un organisme";

if (isset($_POST['button'])) {
    $idorg = $_POST['idorg'] ?? '';
    $design = $_POST['design'] ?? '';
    $lieu = $_POST['lieu'] ?? '';

    if (!empty($idorg) && !empty($design) && !empty($lieu)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO organisme (idorg, design, lieu) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "iss", $idorg, $design, $lieu);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php");
            exit();
        } else {
            $message = "Organisme non ajouté : " . mysqli_error($conn);
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
    <h2>Ajouter un organisme</h2>
    
    <?php if (isset($message)): ?>
        <p class="erreur_message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="idorg">ID Organisme</label>
            <input type="text" id="idorg" name="idorg" required>
        </div>
        <div class="form-group">
            <label for="design">Désignation</label>
            <input type="text" id="design" name="design" required>
        </div>
        <div class="form-group">
            <label for="lieu">Lieu</label>
            <input type="text" id="lieu" name="lieu" required>
        </div>
        <input type="submit" value="Ajouter" name="button">
    </form>
</div>

<?php include_once ROOT_PATH . 'includes/footer.php'; ?>
