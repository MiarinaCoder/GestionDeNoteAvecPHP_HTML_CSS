<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajouter un etudiant</title>
    <link rel="stylesheet" href="style_form.css">
</head>

<body>
<?php
    if(isset($_POST['button']))
    {
        //extraire les informations envoyees dans les variables par la methode POST
        extract($_POST);
        //verification que les champs sont remplis
        if((isset($matricule)&& !empty($matricule))  && (isset($Nom_et)&& !empty($Nom_et)) && (isset($niveau)&& !empty($niveau))  && (isset($parcours)&& !empty($parcours)) && (isset($adr_mail)&& !empty($adr_mail))){
            //connexion a la base de donnees
            include_once "connexion.php"; 
            //requete d'ajout
            $query=mysqli_query($conn,"INSERT INTO etudiant VALUES('$matricule','$Nom_et','$Prenoms_et','$niveau','$parcours','$adr_mail')");
            if($query)
            {
                header("location:index.php");
            }
            else{
                $message="Etudiant non ajoute";
            }
        }
        
        else{
            $message="Veuillez remplir ce champs!";
        }
       
    }
?>
    <div class="form">
        <a href="index.php" class="btn_back"><img src="image/retour.png" alt=""></a>
        <h2>Ajouter un etudiant</h2>
        <p class="erreur_message">
            <?php
                if(isset($message)){
                echo $message;
                }
            ?>
        </p>
        <form action="" method="post">
            <label for="">Matricule</label>
            <input type="text" name="matricule">
            <label for="">Nom</label>
            <input type="text" name="Nom_et">
            <label for="">Prenoms</label>
            <input type="text" name="Prenoms_et">
            Niveau
            <select name="niveau" id="">
                <option value="L1">L1</option>
                <option value="L2">L2</option>
                <option value="L3">L3</option>
                <option value="M1">M1</option>
                <option value="M2">M2</option>
            </select>
            Parcours
            <select name="parcours" id="">
                <option value="GB">GB</option>
                <option value="SR">SR</option>
                <option value="IG">IG</option>
            </select>
            <label>Adr_mail</label>
            <input type="email" name="adr_mail" id="">
            <input type="submit" value="Ajouter" name="button">
        </form>
    </div>
</body>

</html>