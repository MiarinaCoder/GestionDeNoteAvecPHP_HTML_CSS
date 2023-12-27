<?php
//connexion a la base de donnees





        $conn=mysqli_connect("localhost","root","","gestion_soutenance" );
        if(!$conn){
            echo("La connexion a la base de donnees a echoue");
        }
?>