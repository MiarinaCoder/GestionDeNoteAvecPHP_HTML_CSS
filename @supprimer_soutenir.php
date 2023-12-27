<?php
//inclure la connexion a la base de donnees
include_once "connexion.php";
//recuperer la valeur de idorg
$matricule= mysqli_real_escape_string($conn,$_GET['matricule']);
//requete pour supprimer 
$query= mysqli_query($conn," DELETE FROM soutenir WHERE matricule= '$matricule'");
//Redirection a la page @soutenir.php
header("location:@soutenir.php");
?>