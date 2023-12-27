<?php
//connexion a la base de donnees
include_once "connexion.php";

//selection de tous les etudiants
$query=mysqli_query($conn,"SELECT * FROM soutenir ORDER BY Annee_univ ASC ");

if(!empty($_POST['recherche'])){
    $search=htmlspecialchars($_POST['recherche']);

    $query=mysqli_query($conn,"SELECT * FROM soutenir WHERE matricule LIKE '%$search%' or 
    idorg LIKE '%$search%' or Annee_univ LIKE '%$search%' or president LIKE '%$search%' or
     examinateur LIKE '%$search%' or rapporteur_int LIKE '%$search' or rapporteur_ext LIKE '%$search%' ORDER BY Annee_univ ASC");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>soutenir</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <!--navigation-->
        <nav>
            <ul>
                <li><a href="index.php">Etudiant</a></li>
                <li><a href="_professeur.php">Professeur</a></li>
                <li><a href="1organisme.php">Organisme</a></li>
                <li><a href="#">Soutenir</a></li>
                <li><a href="note.php">Gestion de soutenance</a></li>
            </ul>
        </nav>
        
        <!--Recherche des etudiants-->
        <form class="rec" role="search" action="" method="POST">
            <input class="chercher" type="search" placeholder="Recherche" name="recherche">
            <button class="btn_search" type="submit">Search</button>
        </form>
    </header><br>
<div class="container">

<h3><a href="@ajouter_soutenir.php" class="Btn_add"><img src="image/ajout.png" alt="">Ajouter</a></h3><br>

    <table id="soutenir">
        <tr>
            <th>Matricule</th>
            <th>Idorg</th>
            <th>Annee_univ</th>
            <th>Note</th>
            <th>President</th>
            <th>Examinateur</th>
            <th>Rapporteur_int</th>
            <th>Rapporteur_ext</th>
            <th>Modifier</th>
            <th>Supprimer</th>
            <th>Proces verbal</th>
        </tr>

        <section>
        <?php
                if(mysqli_num_rows($query)>0){
                    while($row=mysqli_fetch_assoc($query)){
                        ?>
                        
                
            <tr>
                <td><?=$row["matricule"]?></td>
                <td><?=$row["idorg"]?></td>
                <td><?=$row["Annee_univ"]?></td>
                <td><?=$row["note"]?></td>
                <td><?=$row["president"]?></td>
                <td><?=$row["examinateur"]?></td>
                <td><?=$row["rapporteur_int"]?></td>
                <td><?=$row["rapporteur_ext"]?></td>
                <td><a href="@modifier_soutenir.php?matricule=<?=$row['matricule']?>"><img src="image/modifier.jpg" alt=""></a></td>
                <td><a href="@supprimer_soutenir.php?matricule=<?=$row['matricule']?>" onclick="return confirm('Voulez-vous vraiment supprimer?')"><img src="image/suppre.png" alt=""></a></td>
                <td><a href="genPDF.php?matricule=<?=$row['matricule']?>" class="pv">proces verbal</a></td>
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
</div>
</body>

</html>