<?php
require_once "../config/db.php";

$page_title = "Ajouter un étudiant";

if (isset($_POST['button'])) {
    $matricule = $_POST['matricule'] ?? '';
    $nom_et = $_POST['nom_et'] ?? '';
    $prenoms_et = $_POST['prenoms_et'] ?? '';
    $niveau = $_POST['niveau'] ?? '';
    $parcours = $_POST['parcours'] ?? '';
    $adr_mail = $_POST['adr_mail'] ?? '';

    if (!empty($matricule) && !empty($nom_et) && !empty($niveau) && !empty($parcours) && !empty($adr_mail)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO etudiant (matricule, nom_et, prenoms_et, niveau, parcours, adr_mail) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssss", $matricule, $nom_et, $prenoms_et, $niveau, $parcours, $adr_mail);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php");
            exit();
        } else {
            $message = "Étudiant non ajouté : " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        $message = "Veuillez remplir tous les champs obligatoires !";
    }
}

include_once ROOT_PATH . 'includes/header.php';
?>

<div class="form-container">
    <a href="index.php" class="btn_back"><img src="<?php echo BASE_URL; ?>assets/images/retour.png" alt="Retour" width="30" height="30"></a>
    <h2>Ajouter un étudiant</h2>
    
    <?php if (isset($message)): ?>
        <p class="erreur_message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="" method="post">
        <div class="form-grid">
            <div class="form-group">
                <label for="matricule">Matricule</label>
                <input type="text" id="matricule" name="matricule" required placeholder="Ex: 2547">
            </div>
            <div class="form-group">
                <label for="nom_et">Nom</label>
                <input type="text" id="nom_et" name="nom_et" required placeholder="Ex: RAKOTO">
            </div>
            <div class="form-group">
                <label for="prenoms_et">Prénoms</label>
                <input type="text" id="prenoms_et" name="prenoms_et" placeholder="Ex: Jean Luc">
            </div>
            <div class="form-group">
                <label for="adr_mail">Email</label>
                <input type="email" id="adr_mail" name="adr_mail" required placeholder="exemple@mail.com">
            </div>
            <div class="form-group">
                <label for="niveau">Niveau</label>
                <select name="niveau" id="niveau" required>
                    <option value="L1">L1</option>
                    <option value="L2">L2</option>
                    <option value="L3">L3</option>
                    <option value="M1">M1</option>
                    <option value="M2">M2</option>
                </select>
            </div>
            <div class="form-group">
                <label for="parcours">Parcours</label>
                <select name="parcours" id="parcours" required>
                    <option value="GB">GB</option>
                    <option value="SR">SR</option>
                    <option value="IG">IG</option>
                </select>
            </div>
            <div class="form-group full-width">
                <input type="submit" value="Ajouter l'étudiant" name="button">
            </div>
        </div>
    </form>
</div>

<?php include_once ROOT_PATH . 'includes/footer.php'; ?>
