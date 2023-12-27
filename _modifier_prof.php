<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style_form.css">
    <title>Professeur</title>
</head>
<body>
<?php
        //connexion a la base de donnees
        include_once "connexion.php";

        //on recupere le id dans le lien et protege le valeur entre par l'utilisateur par m...
        $idprof=mysqli_real_escape_string($conn,$_GET['idprof']);

        //afficher les info concernant un professeur
        $query=mysqli_query($conn,"SELECT * FROM professeur WHERE idprof='$idprof'"); 

        //mysqli_fetch_assoc permet d'afficher les donnees dans chaque colonne
        $row=mysqli_fetch_assoc($query);

        if(isset($_POST['button']))
        {
        //extraire les informations envoyees dans les variables par la methode POST
        extract($_POST);
        //verification que les champs sont remplis
        if(isset($idprof) && isset($Nom_prof) && isset($Prenoms_prof)  && isset($Civilite) && isset($Grade)){
            $query=mysqli_query($conn,"UPDATE professeur SET idprof='$idprof',Nom_prof='$Nom_prof',Prenoms_prof='$Prenoms_prof',Civilite='$Civilite',Grade='$Grade' WHERE idprof='$idprof'");

            if($query)
            {
                header("location:_professeur.php");
            }
            else{
                $message= "professeur non modifie";
            }
        }
        else{
            $message= "Veuillez remplir ce champs!";
        }
   }
?>

    <div class="container">
        <div class="form">
                <a href="_professeur.php" class="btn_back"><img src="image/retour.png" alt=""></a>
                <h2>Modifier un Professeur: <?=$row['idprof']?></h2>
                <p class="erreur_message">
                    <?php
                    if(isset($message))
                        echo $message;
                    ?>
                </p>
            <form action="" method="POST">
                <label for="idprof" >Idprof</label>
                <input type="text" name="idprof" value="<?=$row['idprof']?>">
                <label for="Nom_prof">Nom</label>
                <input type="text" name="Nom_prof" id="" value="<?=$row['Nom_prof']?>">
                <label for="Prenoms_prof">Prénoms</label>
                <input type="text" name="Prenoms_prof" id="" value="<?=$row['Prenoms_prof']?>">
                Civilité
                <select name="Civilite" id="">  
                    <option value="Madame" <?php echo $row['Civilite']=='Madame' ?'selected':''?>>Madame</option>
                    <option value="Monsieur" <?php echo $row['Civilite']=='Monsieur' ?'selected':''?>>Monsieur</option>
                    <option value="Mademoiselle" <?php echo $row['Civilite']=='Mademoiselle' ?'selected':''?>>Mademoiselle</option>
                </select>
                Grade
                <select name="Grade" id="">
                    <option value="Professeur tutilaire" <?php echo $row['Grade']=='Professeur tutilaire' ?'selected':''?>>Professeur tutilaire</option>
                    <option value="Professeur" <?php echo $row['Grade']=='Professeur' ?'selected':''?>>Professeur</option>
                    <option value="Maitre de Conference" <?php echo $row['Grade']=='Maitre de Conference' ? 'selected' : ''?>>Maitre de conference</option>
                    <option value="Assistant d Enseignement Superieur et de Recherche" <?php echo $row['Grade']=='Assistant d Enseignement Superieur et de Recherche' ? 'selected' : ''?>>Assistant d'Enseignement Superieur et de Recherche</option>
                    <option value="Docteur HDR" <?php echo $row['Grade']=='Docteur HDR' ? 'selected' : ''?>>Docteur HDR</option>
                    <option value="Docteur en Informatique" <?php echo $row['Grade']=='Docteur en Informatique' ? 'selected' : ''?>>Docteur en Informatique</option>
                    <option value="Doctorant en Informatique" <?php echo $row['Grade']=='Doctorant en Informatique' ? 'selected' : ''?>>Doctorant en Informatique</option>
                </select>
                <input type="submit" value="Modifier" name="button">
            </form>
        </div>
    </div>
</body>
</html>


