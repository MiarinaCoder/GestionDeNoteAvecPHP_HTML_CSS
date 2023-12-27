<?php
//inclure la connexion a la base de donnees
include_once "connexion.php";
//recuperer la valeur de idorg
$idorg= mysqli_real_escape_string($conn,$_GET['idorg']);
//requete pour supprimer 
$query= mysqli_query($conn," DELETE FROM organisme WHERE idorg= '$idorg'");
//Redirection a la page 1organisme.php
header("location:1organisme.php");
?>