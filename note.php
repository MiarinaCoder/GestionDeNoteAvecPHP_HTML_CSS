<?php
//connexion a la base de donnees
include_once "connexion.php";

//selection de tous les etudiants
$query=mysqli_query($conn,"SELECT Annee_univ,etudiant.matricule,Nom_et,Prenoms_et,note FROM etudiant,soutenir 
WHERE soutenir.matricule=etudiant.matricule ORDER BY Annee_univ");

if(!empty($_POST['recherche'])){
    $search=htmlspecialchars($_POST['recherche']);

    $query=mysqli_query($conn,"SELECT Annee_univ,etudiant.matricule,Nom_et,Prenoms_et,note FROM etudiant,soutenir WHERE 
    (soutenir.matricule=etudiant.matricule) AND (etudiant.matricule LIKE  '%$search%' OR Annee_univ LIKE '%$search%' OR 
    Nom_et LIKE '$search' OR Prenoms_et LIKE '%$search%' OR note LIKE '%$search%')
    ORDER BY Annee_univ");
}

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
    <title>Gestion de soutenance</title>
</head>
<body>
<header>
        <!--navigation-->
        <nav>
            <ul>
                <li><a href="index.php">Etudiant</a></li>
                <li><a href="_professeur.php">Professeur</a></li>
                <li><a href="1organisme.php">Organisme</a></li>
                <li><a href="@soutenir.php">Soutenir</a></li>
                <li><a href="#">Gestion de soutenance</a></li>
            </ul>
        </nav>
        
        <!--Recherche des etudiants-->
        <!--<form class="rec" role="search" action="" method="POST">
            <input class="chercher" type="search" placeholder="Recherche" name="recherche">
            <button class="btn_search" type="submit">Search</button>
        </form>-->
    </header><br>

    <div class="container">
    <br><br><br><br><br>
<center>
        <a href="note_entre_2.php" class="Btn_note"><h3>Liste des notes des etudiants entre deux dates</h3></a><br><br>
        <a href="non_soutenu.php" class="Btn_note"><h3>Liste des étudiants qui n’ont pas encore effectué de soutenance</h3></a>
</center>
    </div>
    
</body>
</html>