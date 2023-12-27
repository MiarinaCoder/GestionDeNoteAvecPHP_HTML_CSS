-<?php
//connexion a la base de donnees
include_once "connexion.php";

//selection de tous les etudiants
$query=mysqli_query($conn,"SELECT Annee_univ,etudiant.matricule,Nom_et,Prenoms_et,note,date_soute FROM etudiant,soutenir 
WHERE soutenir.matricule=etudiant.matricule ORDER BY Annee_univ");

extract($_POST);
if(!empty($_POST['recherche'])){
    $search=htmlspecialchars($_POST['recherche']);
if((isset($date1)&& !empty($date2)) && (isset($date2)&& !empty($date2))){
    $query=mysqli_query($conn,"SELECT Annee_univ,etudiant.matricule,Nom_et,Prenoms_et,note,date_soute FROM soutenir,etudiant WHERE 
    (etudiant.matricule=soutenir.matricule) and (date_soute between '$date1' and '$date2')");
}
else{
    $message="Veuillez remplir ce champs!";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Liste des notes des etudiants entre deux dates</title>
</head>
<body>
    
<div class="container">
    <br><br><br><br>
    <fieldset>
<a href="note.php" class="btn_back"><img src="image/retour.png" alt=""></a>
    <br><br>
    <center>
    <h3>Liste des notes des etudiants entre deux dates:</h3><br><br><br>
    <form action="" method="post">
        <input type="date" name="date1" id="" selected>
        <input type="date" name="date2" id="" selected>
        <input type="submit" value="liste des notes entre deux dates" name="recherche">
    </form><br><br><br>
    <p class="erreur_message">
            <?php
                if(isset($message)){
                echo $message;
                }
            ?>
        </p>
  <table>
    <tr>
        <th>Annee_univ</th>
        <th>Matricule</th>
        <th>Nom</th>
        <th>Prénoms</th>
        <th>Note</th>
        <th>Date</th>
    </tr>
    <section>
        <?php
                if(mysqli_num_rows($query)>0){
                    while($row=mysqli_fetch_assoc($query)){
                        ?>
                        
                
            <tr>
                <td><?=$row["Annee_univ"]?></td>
                <td><?=$row["matricule"]?></td>
                <td><?=$row["Nom_et"]?></td>
                <td><?=$row["Prenoms_et"]?></td>
                <td><?=$row["note"]?></td>
                <td><?=$row["date_soute"]?></td>
            </tr>
       
        <?php
                    }
                }
                else{
                    ?>
                    <p>Aucun utilisateur trouve</p>
                    <?php
                }
                ?>
    </section>

  </table><br><br><br>
  </center>
</fieldset>

</div>
</body>
</html>