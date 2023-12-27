<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style_form.css">
    <title>soutenir</title>
</head>
<body>
    <?php
     //connexion a la base de donnees
     include_once "connexion.php";
     //selectionner tous les etudiants par niveau
     $query_et="SELECT DISTINCT etudiant.matricule FROM etudiant LEFT OUTER JOIN soutenir 
     ON soutenir.matricule=etudiant.matricule WHERE (note IS NULL) AND (niveau='L1')";
     $mat = mysqli_query($conn, $query_et); 

     $query_et1="SELECT DISTINCT etudiant.matricule FROM etudiant LEFT OUTER JOIN soutenir 
     ON soutenir.matricule=etudiant.matricule WHERE (note IS NULL) AND (niveau='L2')";
     $mat1 = mysqli_query($conn, $query_et1); 

     $query_et2="SELECT DISTINCT etudiant.matricule FROM etudiant  LEFT OUTER JOIN soutenir 
     ON soutenir.matricule=etudiant.matricule WHERE (note IS NULL)  AND (niveau='L3')";
     $mat2 = mysqli_query($conn, $query_et2); 

     $query_et3="SELECT DISTINCT etudiant.matricule FROM etudiant  LEFT OUTER JOIN soutenir 
     ON soutenir.matricule=etudiant.matricule WHERE (note IS NULL) AND (niveau='M1')";
     $mat3 = mysqli_query($conn, $query_et3); 

     $query_et4="SELECT DISTINCT etudiant.matricule FROM etudiant  LEFT OUTER JOIN soutenir 
     ON soutenir.matricule=etudiant.matricule WHERE (note IS NULL) AND (niveau='M2')";
     $mat4 = mysqli_query($conn, $query_et4); 

     $query_org="SELECT DISTINCT idorg FROM organisme";
     $org = mysqli_query($conn, $query_org); 

     //selectionner le nom complet de professeur 
     $query_prof="SELECT DISTINCT (CONCAT(Nom_prof,' ',Prenoms_prof)) AS Nom_complet FROM professeur";
     $prof = mysqli_query($conn, $query_prof);

     $query_prof1="SELECT DISTINCT (CONCAT(Nom_prof,' ',Prenoms_prof)) AS Nom_complet FROM professeur";
     $prof1 = mysqli_query($conn, $query_prof1);

     $query_prof2="SELECT DISTINCT (CONCAT(Nom_prof,' ',Prenoms_prof)) AS Nom_complet FROM professeur";
     $prof2 = mysqli_query($conn, $query_prof2);

    if(isset($_POST['button'])){
            //extraire les informations envoyees dans les variables par la methode POST
            extract($_POST);
            //verification que les champs sont remplis
            if((isset($matricule)&& !empty($matricule))  && (isset($idorg)&& !empty($idorg)) 
            && (isset($Annee_univ)&& !empty($Annee_univ)) && (isset($president)&& !empty($president))
             && (isset($examinateur)&& !empty($examinateur)) && (isset($rapporteur_int)&& !empty($rapporteur_int)) 
             && (isset($date_soute)&& !empty($date_soute))){
               
                //requete d'ajout
                $query=mysqli_query($conn,"INSERT INTO soutenir VALUES
                ('$matricule',$idorg,'$Annee_univ','$note','$president','$examinateur','$rapporteur_int','$rapporteur_ext','$date_soute')");
                if($query)
                {
                    header("location: @soutenir.php");
                }
                else{
                    $message="soutenir non ajoute";
                }
            }
            else{
                $message="Veuillez remplir ce champs!";
            }
    }
    ?>
    <div class="form">
    <a href="@soutenir.php" class="btn_back"><img src="image/retour.png" alt=""></a>
        <h2>Soutenir un etudiant</h2>
        <p class="erreur_message">
            <?php
                if(isset($message)){
                echo $message;
                }
            ?>
        </p>

        <form action="" method="POST">
            <label for="matricule">Matricule</label>
            <select name="matricule" id="">
            <optgroup label="L1">
            <?php 
            while ($row_et = mysqli_fetch_assoc($mat)) {
                $selected='';
                if(isset($_POST['matricule']) && $_POST['matricule']==$row_et['matricule']){
                    $selected='selected';
                }
                echo "<option value='" . $row_et['matricule'] . "'".$selected.">" . $row_et['matricule'] . "</option>";
        } ?>
        </optgroup>
        <optgroup label="L2">
        <?php 
            while ($row_et1 = mysqli_fetch_assoc($mat1)) {
                $selected='';
                if(isset($_POST['matricule']) && $_POST['matricule']==$row_et1['matricule']){
                    $selected='selected';
                }
                echo "<option value='" . $row_et1['matricule'] . "'".$selected.">" . $row_et1['matricule'] . "</option>";
        } ?>
        </optgroup>
        <optgroup label="L3">
        <?php 
            while ($row_et2 = mysqli_fetch_assoc($mat2)) {
                $selected='';
                if(isset($_POST['matricule']) && $_POST['matricule']==$row_et2['matricule']){
                    $selected='selected';
                }
                echo "<option value='" . $row_et2['matricule'] . "'".$selected.">" . $row_et2['matricule'] . "</option>";
        } ?>
        </optgroup>
        <optgroup label="M1">
        <?php
        while ($row_et3 = mysqli_fetch_assoc($mat3)) {
                $selected='';
                if(isset($_POST['matricule']) && $_POST['matricule']==$row_et3['matricule']){
                    $selected='selected';
                }
                echo "<option value='" . $row_et3['matricule'] . "'".$selected.">" . $row_et3['matricule'] . "</option>";
        } ?>
        </optgroup>
        <optgroup label="M2">
        <?php
        while ($row_et4 = mysqli_fetch_assoc($mat4)) {
            $selected='';
            if(isset($_POST['matricule']) && $_POST['matricule']==$row_et4['matricule']){
                $selected='selected';
            }
            echo "<option value='" . $row_et4['matricule'] . "'".$selected.">" . $row_et4['matricule'] . "</option>";
    } ?>
        </optgroup>
        </select>
            <label for="idorg">idorg</label>
            <select name="idorg" id="">
            <?php 
            while ($row_org = mysqli_fetch_assoc($org)) {
                $selected='';
                if(isset($_POST['idorg']) && $_POST['idorg']==$row_et['idorg']){
                    $selected='selected';
                }
                echo "<option value='" . $row_org['idorg'] . "'".$selected.">" . $row_org['idorg'] . "</option>";
        } ?>
                </select>
            <label for="Annee_univ">Annee_univ</label>
            <input type="text" name="Annee_univ" id="">
            <label for="note">Note</label>
            <input type="number" name="note" id="">
            <label for="president">president</label>
            <select name="president" id="">
            <?php while ($row_prof = mysqli_fetch_assoc($prof)) {
                $selected='';
                if(isset($_POST['president']) && $_POST['president']==$row_prof['Nom_complet']){
                    $selected='selected';
                }
                echo "<option value='" . $row_prof['Nom_complet'] . "'".$selected.">" . $row_prof['Nom_complet'] . "</option>";
        } ?>
            </select>

            <label for="examinateur">Examinateur</label>
            <select name="examinateur" id="">
            <?php 
            while ($row_prof1 = mysqli_fetch_assoc($prof1)) {
                $selected='';
                if(isset($_POST['examinateur']) && $_POST['examinateur']==$row_prof1['Nom_complet']){
                    $selected='selected';
                }
                echo "<option value='" . $row_prof1['Nom_complet'] . "'".$selected.">" . $row_prof1['Nom_complet'] . "</option>";
        } ?>
                </select>

            <label for="rapporteur_int">rapporteur_int</label>
            <select name="rapporteur_int" id="">
            <?php while ($row_prof2 = mysqli_fetch_assoc($prof2)) {
                $selected='';
                if(isset($_POST['rapporteur_int']) && $_POST['rapporteur_int']==$row_prof2['Nom_complet']){
                    $selected='selected';
                }
                echo "<option value='" . $row_prof2['Nom_complet'] . "'".$selected.">" . $row_prof2['Nom_complet'] . "</option>";
                 } ?>
                </select>
            <label for="rapporteur_ext">rapporteur_ext</label>
            <input type="text" name="rapporteur_ext" id="">
            <label>date</label>
            <input type="date" name="date_soute" id="">
            <input type="submit" value="Ajouter" name="button">
        </form>
    </div>
</body>
</html>