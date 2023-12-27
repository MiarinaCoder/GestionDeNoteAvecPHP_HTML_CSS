<?php
        include_once "connexion.php";
        $idprof= mysqli_real_escape_string($conn,$_GET['idprof']);
        $query= mysqli_query($conn," DELETE FROM professeur WHERE idprof= '$idprof'");
        header("Location:_professeur.php");
?>