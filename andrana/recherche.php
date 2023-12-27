<?php
//connexion a la base de donnees
include_once "connexion.php";

//selection de tous les etudiants
$query=mysqli_query($conn,"SELECT * FROM etudiant ");

//isset($_GET['recherche']) &&
if(!empty($_POST['recherche'])){
    $search=htmlspecialchars($_POST['recherche']);
    $query=$conn->query('SELECT * FROM etudiant WHERE matricule LIKE "%'.$search.'%" or Nom LIKE "%'.$search.'%" or Prenoms LIKE "%'.$search.'%"');

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form class="rec" role="search" action="" method="POST">
        <input class="chercher" type="search" placeholder="Search" name="recherche">
        <button class="btn_search" type="submit">Search</button>
    </form>
    <section>
        <?php
                if($query->num_rows>0){
                    while($row=$query->fetch_assoc()){
                        ?>
                        
               <table>  
            <tr>
                <td><?=$row["matricule"]?></td>
                <td><?=$row["Nom"]?></td>
                <td><?=$row["Prenoms"]?></td>
                <td><?=$row["niveau"]?></td>
                <td><?=$row["parcours"]?></td>
                <td><?=$row["adr_mail"]?></td>
                <td><a href="modifier.php?matricule=<?=$row['matricule']?>"><img src="" alt="">Modifier</a></td>
                <td><a href="supprimer.php?matricule=<?=$row['matricule']?>"><img src="" alt="">Supprimer</a></td>
            </tr>
        </table>
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
</body>

</html>