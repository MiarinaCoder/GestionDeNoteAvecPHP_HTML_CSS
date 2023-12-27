<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modifier un organisme</title>
    <link rel="stylesheet" href="style_form.css">
</head>
<body>
<?php
        //connexion a la base de donnees
        include_once "connexion.php";

        //on recupere le id dans le lien
        $idorg=$_GET['idorg'];

        //afficher les info concernant un organisme
        $query=mysqli_query($conn,"SELECT * FROM organisme WHERE idorg= $idorg"); 

        $row=mysqli_fetch_assoc($query);

        if(isset($_POST['button']))
        {
        //extraire les informations envoyees dans les variables par la methode POST
        extract($_POST);
        //verification que les champs sont remplis
        if(isset($idorg) && isset($design) && isset($lieu)){
            $query=mysqli_query($conn,"UPDATE organisme SET idorg=$idorg,design='$design',lieu='$lieu' WHERE idorg=$idorg ");

            if($query)
            {
                header("location:1organisme.php");
            }
            else{
                $message="organisme non modifie";
            }
        }
        else{
            $message="Veuillez remplir ce champs!";
        }
   }
?>

<div class="form">
        <a href="1organisme.php" class="btn_back"><img src="image\retour.png" alt=""></a>
        <h2>Modifier l' organisme : <?=$row['idorg']?></h2>
        <p class="erreur_message">
        <?php
        if(isset($message))
            echo $message;
        ?>
        </p>
        <form action="" method="POST">
            <label for="">Idorg</label>
            <input type="text" name="idorg" value="<?=$row['idorg']?>">
            <label for="">design</label>
            <input type="text" name="design" value="<?=$row['design']?>">
            <label for="">lieu</label>
            <input type="text" name="lieu" value="<?=$row['lieu']?>">
            <input type="submit" value="Modifier" name="button">
        </form>
</div>

</body>
</html>