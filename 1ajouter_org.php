<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style_form.css">
    <title>Ajouter un organisme</title>
</head>
<body>
    <?php
    if(isset($_POST['button'])){
            //extraire les informations envoyees dans les variables par la methode POST
            extract($_POST);
            //verification que les champs sont remplis
            if((isset($idorg)&& !empty($idorg))  && (isset($design)&& !empty($design)) && (isset($lieu)&& !empty($lieu)) ){
                //connexion a la base de donnees
                include_once "connexion.php"; 
                //requete d'ajout
                $query=mysqli_query($conn,"INSERT INTO organisme VALUES($idorg,'$design','$lieu')");
                if($query)
                {
                    header("location:1organisme.php");
                }
                else{
                    $message="organisme non ajoute";
                }
            }
            else{
                $message="Veuillez remplir ce champs!";
            }
    }
    ?>
    <div class="form">
    <a href="1organisme.php" class="btn_back"><img src="image/retour.png" alt=""></a>
        <h2>Ajouter un organisme</h2>
        <p class="erreur_message">
            <?php
                if(isset($message)){
                echo $message;
                }
            ?>
        </p>

        <form action="" method="POST">
            <label for="idorg">idorg</label>
            <input type="text" name="idorg" id="">
            <label for="design">design</label>
            <input type="text" name="design" id="">
            <label for="lieu">lieu</label>
            <input type="text" name="lieu" id="">
            <input type="submit" value="Ajouter" name="button">
        </form>
    </div>
</body>
</html>