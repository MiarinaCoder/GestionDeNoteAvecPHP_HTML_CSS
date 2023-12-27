<?php
//connexion a la base de données
include_once "connexion.php";

//selection de tous les organismes
$query=mysqli_query($conn,"SELECT * FROM organisme ORDER BY idorg ASC");

if(!empty($_POST['recherche'])){
        $search=htmlspecialchars($_POST['recherche']);
        $query=mysqli_query($conn,"SELECT * FROM organisme WHERE idorg LIKE '%$search%' or design LIKE '%$search%' or lieu LIKE '%$search%' ORDER BY idorg ASC");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Organisme</title>
</head>
<body>
    <div class="container">
    <header>
        <!--navigation-->
        <nav>
            <ul>
                <li><a href="index.php">Etudiant</a></li>
                <li><a href="_professeur.php">Professeur</a></li>
                <li><a href="#">Organisme</a></li>
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

    <h3><a href="1ajouter_org.php" class="Btn_add"><img src="image/ajout.png">Ajouter un organisme</a></h3><br>
    <table>
        <tr>
            <th>Idorg</th>
            <th>design</th>
            <th>lieu</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        <?php
                    if(mysqli_num_rows($query)>0){
                     while($rows=mysqli_fetch_assoc($query)){
                    ?>
                        <tr>
                        <td><?=$rows['idorg']?></td>
                        <td><?=$rows['design']?></td>
                        <td><?=$rows['lieu']?></td>
                        <!-- Nous allons mettre id de chaque étudiant dans ce lien-->
                        <td><a href="1modifier_org.php?idorg=<?=$rows['idorg']?>"><img src="image/modifier.jpg" alt=""></a></td>
                        <td><a href="1supprimer_org.php?idorg=<?=$rows['idorg']?>" onclick="return confirm('Voulez-vous vraiment supprimer cet organisme?')"><img src="image/suppre.png" alt=""></a></td>
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
    </table>
    </div>
</body>
</html>