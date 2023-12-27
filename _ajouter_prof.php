<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style_form.css">
    <title>Ajouter un professeur</title>
</head>
<body>
<?php
    if(isset($_POST['button']))
    {
        //extraire les informations envoyees dans les variables par la methode POST
        extract($_POST);
        //verification que les champs sont remplis
        if((isset($idprof)&& !empty($idprof))  && (isset($Nom_prof)&& !empty($Nom_prof)) && (isset($Prenoms_prof)&& !empty($Prenoms_prof))  && (isset($Civilite)&& !empty($Civilite)) && (isset($Grade)&& !empty($Grade))){
            //connexion a la base de donnees
            include_once "connexion.php"; 
            //requete d'ajout
            $query=mysqli_query($conn,"INSERT INTO professeur VALUES('$idprof','$Nom_prof','$Prenoms_prof','$Civilite','$Grade')");
            if($query)
            {
                header("location:_professeur.php");
            }
            else{
                $message="Professeur non ajoute";
            }
        }
        
        else{
            $message="Veuillez remplir ce champs!";
        }
       
    }
?>
<div class="form">
<a href="_professeur.php" class="btn_back"><img src="image/retour.png" alt=""></a>
        <h2>Ajouter un professeur</h2>
        <p class="erreur_message">
            <?php
                if(isset($message)){
                echo $message;
                }
            ?>
        </p>
        <form action="" method="post">
            <label for="">idprof</label>
            <input type="text" name="idprof">
            <label for="">Nom</label>
            <input type="text" name="Nom_prof">
            <label for="">Prenoms</label>
            <input type="text" name="Prenoms_prof">
            Civilite
            <select name="Civilite" id="">
                <option value="madame">Madame</option>
                <option value="monsieur">Monsieur</option>
                <option value="mademoiselle">Mademoiselle</option>
            </select>
            Grade
            <select name="Grade" id="">
                <option value="Professeur tutilaire">Professeur tutilaire</option>
                <option value="Professeur">Professeur</option>
                <option value="Maitre de Conference">Maitre de Conference</option>
                <option value="Assistant d Enseignement Superieur et de Recherche">Assistant d Enseignement Superieur et de Recherche</option>
                <option value="Docteur HDR">Docteur HDR</option>
                <option value="Docteur en Informatique">Docteur en Informatique</option>
                <option value="Doctorant en Informatique">Doctorant en Informatique</option>
            </select>
            <input type="submit" value="Ajouter" name="button">
            </div>
        </form>
    </div>
</html>
</body>