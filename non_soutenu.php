<?php
//connexion a la base de donnees
include_once "connexion.php";

$query_et=mysqli_query($conn,"SELECT etudiant.matricule,Nom_et,Prenoms_et,niveau,parcours,adr_mail 
FROM etudiant LEFT OUTER JOIN soutenir ON soutenir.matricule=etudiant.matricule WHERE note IS NULL");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Liste des étudiants qui n’ont pas encore effectué de soutenance</title>
</head>
<body>
    
<div class="container">
    <br><br>


    <fieldset>

    <a href="note.php" class="btn_back"><img src="image/retour.png" alt=""></a>
    <center>
  <h3>Liste des étudiants qui n’ont pas encore effectué de soutenance:</h3><br><br><br>
  <table>
    <tr>
        <th>matricule</th>
        <th>Nom</th>
        <th>Prénoms</th>
        <th>Niveau</th>
        <th>Parcours</th>
        <th>Adr_mail</th>
    </tr>
    <section>
        <?php
                if(mysqli_num_rows($query_et)>0){
                    while($row_et=mysqli_fetch_assoc($query_et)){
                        ?>
                        
                
            <tr>
                <td><?=$row_et["matricule"]?></td>
                <td><?=$row_et["Nom_et"]?></td>
                <td><?=$row_et["Prenoms_et"]?></td>
                <td><?=$row_et["niveau"]?></td>
                <td><?=$row_et["parcours"]?></td>
                <td><?=$row_et["adr_mail"]?></td>               
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

  </table>
  </center>
  </fieldset>
  
</div>
</body>
</html>