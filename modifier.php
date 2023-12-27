<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modifier un etudiant</title>
    <link rel="stylesheet" href="style_form.css">
</head>

<body>
<?php
        //connexion a la base de donnees
        include_once "connexion.php";
        //on recupere le id dans le lien
        $matricule=mysqli_real_escape_string($conn,$_GET['matricule']);
        //afficher les info concernant un etudiant
        $query=mysqli_query($conn,"SELECT * FROM etudiant WHERE matricule='$matricule'"); 
        $row=mysqli_fetch_assoc($query);

        if(isset($_POST['button']))
        {
        //extraire les informations envoyees dans les variables par la methode POST
        extract($_POST);
        //verification que les champs sont remplis
        if(isset($matricule) && isset($Nom_et) && isset($Prenoms_et) && isset($niveau)  && isset($parcours) && isset($adr_mail)){
            $query=mysqli_query($conn,"UPDATE etudiant SET matricule='$matricule',Nom_et='$Nom_et',Prenoms_et='$Prenoms_et',niveau='$niveau',parcours='$parcours',adr_mail='$adr_mail' WHERE matricule='$matricule'");

            if($query)
            {
                header("location:index.php");
            }
            else{
                $message="Etudiant non modifie";
            }
        }
        else{
            $message="Veuillez remplir ce champs!";
        }
   }
?>
    <div class="form">
        <a href="index.php" class="btn_back"><img src="image\retour.png" alt=""></a>
        <h2>Modifier un etudiant : <?=$row['matricule']?></h2>
        <p class="erreur_message">
        <?php
        if(isset($message))
            echo $message;
        ?>
        </p>
        <form action="?" method="POST">
            <label for="">Matricule</label>
            <input type="text" name="matricule" value="<?=$row['matricule']?>">
            <label for="">Nom</label>
            <input type="text" name="Nom_et" value="<?=$row['Nom_et']?>">
            <label for="">Prenoms</label>
            <input type="text" name="Prenoms_et" value="<?=$row['Prenoms_et']?>">
            Niveau
            <select name="niveau" id="">
                <option value="L1" <?php echo $row['niveau']=='L1' ? 'selected' : ''?>>L1</option>
                <option value="L2" <?php echo $row['niveau']=='L2' ? 'selected' : ''?>>L2</option>
                <option value="L3" <?php echo $row['niveau']=='L3' ? 'selected' : ''?>>L3</option>
                <option value="M1" <?php echo $row['niveau']=='M1' ? 'selected' : ''?>>M1</option>
                <option value="M2" <?php echo $row['niveau']=='M2' ? 'selected' : ''?>>M2</option>
            </select>
            Parcours
            <select name="parcours" id="">
                <option value="GB" <?php echo $row['parcours']=='GB' ? 'selected':''?>>GB</option>
                <option value="SR" <?php echo $row['parcours']=='SR' ? 'selected':''?>>SR</option>
                <option value="IG" <?php echo $row['parcours']=='IG'? 'selected':''?>>IG</option>
            </select>
            <label>Adr_mail</label>
            <input type="email" for="adr_mail" name="adr_mail" id="" value="<?=$row['adr_mail']?>">
            <input type="submit" value="Modifier" name="button">
        </form>
    </div>
</body>
</html>