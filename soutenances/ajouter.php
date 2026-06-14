<?php
require_once "../config/db.php";

$page_title = "Soutenir un étudiant";

// Sélectionner tous les étudiants par niveau (ceux qui n'ont pas encore soutenu)
function get_students_by_level($conn, $level) {
    $sql = "SELECT DISTINCT etudiant.matricule FROM etudiant LEFT OUTER JOIN soutenir 
            ON soutenir.matricule=etudiant.matricule WHERE (note IS NULL) AND (niveau=?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $level);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

$mat = get_students_by_level($conn, 'L1');
$mat1 = get_students_by_level($conn, 'L2');
$mat2 = get_students_by_level($conn, 'L3');
$mat3 = get_students_by_level($conn, 'M1');
$mat4 = get_students_by_level($conn, 'M2');

$query_org = "SELECT DISTINCT idorg FROM organisme";
$org = mysqli_query($conn, $query_org);

$query_prof_sql = "SELECT DISTINCT (CONCAT(nom_prof,' ',prenoms_prof)) AS Nom_complet FROM professeur";
$prof = mysqli_query($conn, $query_prof_sql);
$prof1 = mysqli_query($conn, $query_prof_sql);
$prof2 = mysqli_query($conn, $query_prof_sql);

if (isset($_POST['button'])) {
    $matricule = $_POST['matricule'] ?? '';
    $idorg = $_POST['idorg'] ?? '';
    $annee_univ = $_POST['annee_univ'] ?? '';
    $note = $_POST['note'] !== '' ? $_POST['note'] : null;
    $president = $_POST['president'] ?? '';
    $examinateur = $_POST['examinateur'] ?? '';
    $rapporteur_int = $_POST['rapporteur_int'] ?? '';
    $rapporteur_ext = $_POST['rapporteur_ext'] ?? '';
    $date_soute = $_POST['date_soute'] ?? '';

    if (!empty($matricule) && !empty($idorg) && !empty($annee_univ) && !empty($president) && !empty($examinateur) && !empty($rapporteur_int) && !empty($date_soute)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO soutenir (matricule, idorg, Annee_univ, note, president, examinateur, rapporteur_int, rapporteur_ext, date_soute) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sisssssss", $matricule, $idorg, $annee_univ, $note, $president, $examinateur, $rapporteur_int, $rapporteur_ext, $date_soute);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php");
            exit();
        } else {
            $message = "Soutenance non ajoutée : " . mysqli_error($conn);
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
    <h2>Soutenir un étudiant</h2>
    
    <?php if (isset($message)): ?>
        <p class="erreur_message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="matricule">Matricule</label>
            <select name="matricule" id="matricule" required>
                <option value="">-- Sélectionner un étudiant --</option>
                <optgroup label="L1">
                    <?php while ($row_et = mysqli_fetch_assoc($mat)): ?>
                        <option value="<?php echo htmlspecialchars($row_et['matricule']); ?>"><?php echo htmlspecialchars($row_et['matricule']); ?></option>
                    <?php endwhile; ?>
                </optgroup>
                <optgroup label="L2">
                    <?php while ($row_et = mysqli_fetch_assoc($mat1)): ?>
                        <option value="<?php echo htmlspecialchars($row_et['matricule']); ?>"><?php echo htmlspecialchars($row_et['matricule']); ?></option>
                    <?php endwhile; ?>
                </optgroup>
                <optgroup label="L3">
                    <?php while ($row_et = mysqli_fetch_assoc($mat2)): ?>
                        <option value="<?php echo htmlspecialchars($row_et['matricule']); ?>"><?php echo htmlspecialchars($row_et['matricule']); ?></option>
                    <?php endwhile; ?>
                </optgroup>
                <optgroup label="M1">
                    <?php while ($row_et = mysqli_fetch_assoc($mat3)): ?>
                        <option value="<?php echo htmlspecialchars($row_et['matricule']); ?>"><?php echo htmlspecialchars($row_et['matricule']); ?></option>
                    <?php endwhile; ?>
                </optgroup>
                <optgroup label="M2">
                    <?php while ($row_et = mysqli_fetch_assoc($mat4)): ?>
                        <option value="<?php echo htmlspecialchars($row_et['matricule']); ?>"><?php echo htmlspecialchars($row_et['matricule']); ?></option>
                    <?php endwhile; ?>
                </optgroup>
            </select>
        </div>

        <div class="form-group">
            <label for="idorg">ID Organisme</label>
            <select name="idorg" id="idorg" required>
                <option value="">-- Sélectionner un organisme --</option>
                <?php while ($row_org = mysqli_fetch_assoc($org)): ?>
                    <option value="<?php echo htmlspecialchars($row_org['idorg']); ?>"><?php echo htmlspecialchars($row_org['idorg']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="annee_univ">Année Universitaire</label>
            <input type="text" name="annee_univ" id="annee_univ" placeholder="ex: 2022-2023" required>
        </div>

        <div class="form-group">
            <label for="note">Note</label>
            <input type="number" step="0.01" name="note" id="note">
        </div>

        <div class="form-group">
            <label for="president">Président</label>
            <select name="president" id="president" required>
                <option value="">-- Sélectionner un professeur --</option>
                <?php while ($row_prof = mysqli_fetch_assoc($prof)): ?>
                    <option value="<?php echo htmlspecialchars($row_prof['Nom_complet']); ?>"><?php echo htmlspecialchars($row_prof['Nom_complet']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="examinateur">Examinateur</label>
            <select name="examinateur" id="examinateur" required>
                <option value="">-- Sélectionner un professeur --</option>
                <?php while ($row_prof = mysqli_fetch_assoc($prof1)): ?>
                    <option value="<?php echo htmlspecialchars($row_prof['Nom_complet']); ?>"><?php echo htmlspecialchars($row_prof['Nom_complet']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="rapporteur_int">Rapporteur Interne</label>
            <select name="rapporteur_int" id="rapporteur_int" required>
                <option value="">-- Sélectionner un professeur --</option>
                <?php while ($row_prof = mysqli_fetch_assoc($prof2)): ?>
                    <option value="<?php echo htmlspecialchars($row_prof['Nom_complet']); ?>"><?php echo htmlspecialchars($row_prof['Nom_complet']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="rapporteur_ext">Rapporteur Externe</label>
            <input type="text" name="rapporteur_ext" id="rapporteur_ext">
        </div>

        <div class="form-group">
            <label for="date_soute">Date</label>
            <input type="date" name="date_soute" id="date_soute" required>
        </div>

        <input type="submit" value="Ajouter la soutenance" name="button">
    </form>
</div>

<?php include_once ROOT_PATH . 'includes/footer.php'; ?>
