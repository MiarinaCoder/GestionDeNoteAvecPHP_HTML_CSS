<?php
//connexion a la base de donnees
include_once "connexion.php";


// Récupérer la liste de tous les niveaux
$sql="SELECT DISTINCT niveau FROM etudiant UNION SELECT 'Tous les niveaux' 
AS niveau ORDER BY CASE WHEN niveau='M2' THEN 6 WHEN niveau='M1' THEN
5 WHEN niveau='L3' THEN 4 WHEN niveau='L2' THEN 3 WHEN niveau='L1' THEN 2 ELSE 1 END,niveau";
$result = mysqli_query($conn, $sql);

// Récupérer la liste de tous les niveaux
$req = "SELECT DISTINCT parcours FROM etudiant UNION SELECT 'Tous les parcours' 
AS parcours ORDER BY CASE WHEN parcours='IG' THEN 4 WHEN parcours='SR' 
THEN 3 WHEN parcours='GB' THEN 2  ELSE 1 END,parcours" ;
$resultat = mysqli_query($conn, $req);

//selection de tous les etudiants
$query=mysqli_query($conn,"SELECT * FROM etudiant ORDER BY matricule ASC ");

if(isset($_POST['recherche']) || isset($_POST['niveau'])){
    $search=htmlspecialchars($_POST['recherche']);
    $niveau= isset($_POST['niveau']) ? $_POST['niveau'] : '';
    $parcours=isset($_POST['parcours']) ? $_POST['parcours']: '';

if($niveau=='Tous les niveaux' && $parcours=='Tous les parcours'){
    $query="SELECT * FROM etudiant WHERE matricule LIKE '%$search%' or Nom_et LIKE '%$search%'
    or Prenoms_et LIKE '%$search%'  ORDER BY matricule ASC";
}
elseif($niveau=='Tous les niveaux' && $parcours!='Tous les parcours'){
    $query="SELECT * FROM etudiant WHERE parcours='$parcours' 
    AND (matricule LIKE '%$search%' or Nom_et LIKE '%$search%'
    or Prenoms_et LIKE '%$search%' ) ORDER BY matricule ASC";
}
    elseif($niveau!='Tous les niveaux' && $parcours=='Tous les parcours')
    {
    $query="SELECT * FROM etudiant WHERE niveau='$niveau' AND (matricule LIKE '%$search%' or Nom_et LIKE '%$search%'
    or Prenoms_et LIKE '%$search%' ) ORDER BY matricule ASC";
    }
    else{
    $query="SELECT * FROM etudiant WHERE niveau='$niveau' 
    AND parcours='$parcours' AND (matricule LIKE '%$search%' or Nom_et LIKE '%$search%'
     or Prenoms_et LIKE '%$search%' ) ORDER BY matricule ASC";  
} 
$query=mysqli_query($conn,$query);  
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Etudiant</title>
</head>

<body>
    <header>
        <!--navigation-->
        <nav>
            <ul>
                <li><a href="#">Etudiant</a></li>
                <li><a href="_professeur.php">Professeur</a></li>
                <li><a href="1organisme.php">Organisme</a></li>
                <li><a href="@soutenir.php">Soutenir</a></li>
                <li><a href="note.php">Gestion de soutenance</a></li>
            </ul>
        </nav>
        <!--Recherche des etudiants-->
        <form class="rec" role="search" action="" method="POST">
        Niveau
            <select name="niveau" id="">
            <?php while ($niv = mysqli_fetch_assoc($result)) {
                $selected='';
                if(isset($_POST['niveau']) && $_POST['niveau']==$niv['niveau']){
                    $selected='selected';
                }
                echo "<option value='" . $niv['niveau'] . "'".$selected.">" . $niv['niveau'] . "</option>";
        ?>

                <?php } ?>
            </select>
            Parcours
            <select name="parcours" id="">
            <?php while ($parc = mysqli_fetch_assoc($resultat)) {
                $selected='';
                if(isset($_POST['parcours']) && $_POST['parcours']==$parc['parcours']){
                    $selected='selected';
                }
                echo "<option value='" . $parc['parcours'] . "'".$selected.">" . $parc['parcours'] . "</option>";
                ?>
            <?php }?>
            </select>
       
            <input class="chercher" type="search" placeholder="Recherche" name="recherche">
            <button class="btn_search" type="submit">Search</button>
        </form>
    </header><br>
    <!-- fin de header-->

    <!--contenue de la page-->
    <div class="container">
        <!--lien d'ajout-->
        <h3><a href="ajouter.php" class="Btn_add"><img src="image/ajout.png">Ajouter un etudiant</a></h3><br>
    <!--titre de la table-->
        <table>
            <tr id="items">
                <th>matricule</th>
                <th>Nom</th>
                <th>Prénoms</th>
                <th>Niveau</th>
                <th>Parcours</th>
                <th>Adr_mail</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
    <!--fin de titre de la table-->       
    <section>
        <?php
                if(mysqli_num_rows($query)>0){
                    while($row=mysqli_fetch_assoc($query)){
        ?> 
            <tr>
                <td><?=$row["matricule"]?></td>
                <td><?=$row["Nom_et"]?></td>
                <td><?=$row["Prenoms_et"]?></td>
                <td><?=$row["niveau"]?></td>
                <td><?=$row["parcours"]?></td>
                <td><?=$row["adr_mail"]?></td>
                <td><a href="modifier.php?matricule=<?=$row['matricule']?>"><img src="image/modifier.jpg" alt=""></a></td>
                <td><a href="supprimer.php?matricule=<?=$row['matricule']?>" onclick="return confirm('Voulez-vous vraiment supprimer cet etudiant?')"><img class="delete-icon" src="image/suppre.png"></a></td>
            </tr>
       
        <?php
                    }
                }

        ?>
                    

                
    </section>

        </table><br>

        <label for="">Nombre d'etudiants:</label>
        <input type="text" name="" id="" value="<?php echo mysqli_num_rows($query);?>" readonly>
    </div>
</body>

</html>