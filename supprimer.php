<?php
    include_once "connexion.php";
    $matricule= mysqli_real_escape_string($conn,$_GET['matricule']);
    $query= mysqli_query($conn," DELETE FROM etudiant WHERE matricule= '$matricule'");
    header("Location:index.php");
?>