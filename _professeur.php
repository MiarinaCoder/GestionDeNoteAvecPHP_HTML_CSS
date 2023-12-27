<?php
//connexion a la base soutenance donnees
include_once "connexion.php";

//selection soutenance tous les etudiants
$query=mysqli_query($conn,"SELECT * FROM professeur ORDER BY idprof ASC ");

if(!empty($_POST['recherche'])){
    $search=htmlspecialchars($_POST['recherche']);

    $query=mysqli_query($conn,"SELECT * FROM professeur WHERE idprof LIKE '%$search%' or Nom_prof 
    LIKE '%$search%' or Prenoms_prof LIKE '%$search%' ORDER BY idprof ASC");

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Professeur</title>
</head>
<body>
<header>
        <!--navigation-->
        <nav>
            <ul>
                <li><a href="index.php">Etudiant</a></li>
                <li><a href="#">Professeur</a></li>
                <li><a href="1organisme.php">Organisme</a></li>
                <li><a href="@soutenir.php">Soutenir</a></li>
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
        <h3><a href="_ajouter_prof.php" class="Btn_add"><img src="image/ajout.png" alt="">Ajouter un professeur</a></h3><br>

  <table>
    <tr>
        <th>Idprof</th>
        <th>Nom</th>
        <th>Prénoms</th>
        <th>Civilité</th>
        <th>Grade</th>
        <th>Modifier</th>
        <th>Supprimer</th>
    </tr>
    <section>
        <?php
                if(mysqli_num_rows($query)>0){
                    while($row=mysqli_fetch_assoc($query)){
                        ?>
                        
                
            <tr>
                <td><?=$row["idprof"]?></td>
                <td><?=$row["Nom_prof"]?></td>
                <td><?=$row["Prenoms_prof"]?></td>
                <td><?=$row["Civilite"]?></td>
                <td><?=$row["Grade"]?></td>
                <td><a href="_modifier_prof.php?idprof=<?=$row['idprof']?>"><img src="image/modifier.jpg" alt=""></a></td>
                <td><a href="_supprimer_prof.php?idprof=<?=$row['idprof']?>" 
                onclick="return confirm('Voulez-vous vraiment supprimer ce professeur?')"><img src="image/suppre.png" alt=""></a></td>
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