<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style_form.css">
    <title>Soutenir</title>
</head>
<body>
<?php
    //connexion a la base de donnees
    include_once "connexion.php";

    $query_prof="SELECT DISTINCT (CONCAT(Nom_prof,' ',Prenoms_prof)) AS Nom_complet FROM professeur";
    $prof = mysqli_query($conn, $query_prof);
    
    $query_prof1="SELECT DISTINCT (CONCAT(Nom_prof,' ',Prenoms_prof)) AS Nom_complet FROM professeur";
    $prof1 = mysqli_query($conn, $query_prof1);

    $query_prof2="SELECT DISTINCT (CONCAT(Nom_prof,' ',Prenoms_prof)) AS Nom_complet FROM professeur";
    $prof2 = mysqli_query($conn, $query_prof2);

        //on recupere le id dans le lien et protege le valeur entre par l'utilisateur par m...
        $matricule=mysqli_real_escape_string($conn,$_GET['matricule']);

        //afficher les info concernant un professeur
        $query=mysqli_query($conn,"SELECT * FROM soutenir WHERE matricule='$matricule'"); 

        //mysqli_fetch_assoc permet d'afficher les donnees dans chaque colonne
        $row=mysqli_fetch_assoc($query);

        if(isset($_POST['button']))
        {
        //extraire les informations envoyees dans les variables par la methode POST
        extract($_POST);
        //verification que les champs sont remplis
        if(isset($matricule) && isset($idorg) && isset($Annee_univ) && isset($note) && isset($president) && 
        isset($examinateur) && isset($rapporteur_int)){
        
            $query=mysqli_query($conn,"UPDATE soutenir SET matricule='$matricule',
            idorg='$idorg',Annee_univ='$Annee_univ',note=$note,president='$president',
            examinateur='$examinateur',rapporteur_int='$rapporteur_int',
            rapporteur_ext='$rapporteur_ext' WHERE matricule='$matricule'");

            if($query)
            {
                header("location:@soutenir.php");
            }
            else{
                $message= "soutenir non modifie";
            }
        }
        else{
            $message= "Veuillez remplir ce champs!";
        }
   }
?>

    <div class="container">
        <div class="form">
                <a href="@soutenir.php" class="btn_back"><img src="image/retour.png" alt=""></a>
                <h2>Modifier : <?=$row['matricule']?></h2>
                <p class="erreur_message">
                    <?php
                    if(isset($message))
                        echo $message;
                    ?>
                </p>
            <form action="" method="POST">
                <label>matricule</label>
                <input type="text" name="matricule" value="<?=$row['matricule']?>">
                <label>idorg</label>
                <input type="text" name="idorg" id="" value="<?=$row['idorg']?>">
                <label>Annee_univ</label>
                <input type="text" name="Annee_univ" id="" value="<?=$row['Annee_univ']?>">
                <label>Note</label>
                <input type="number" name="note" id="" value="<?=$row['note']?>">
                <label>president</label>
                <input type="text" name="president" id="" value="<?=$row['president']?>">

                <label>examinateur</label>
                <input type="text" name="examinateur" id="" value="<?=$row['examinateur']?>">

                <label>rapporteur_int</label>
                <input type="text" name="rapporteur_int" id="" value="<?=$row['rapporteur_int']?>">
                
                <label>rapporteur_ext</label>
                <input type="text" name="rapporteur_ext" id="" value="<?=$row['rapporteur_ext']?>">
                <input type="submit" value="Modifier" name="button">
            </form>
        </div>
    </div>
</body>
</html>


