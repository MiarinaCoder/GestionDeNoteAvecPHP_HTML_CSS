<?php
            //inclure la page de connexion
            include_once "connexion.php";
            //requete pour afficher la liste des etudiants
            $query=mysqli_query($conn,"SELECT * FROM etudiant ORDER BY matricule ASC" );
            if(mysqli_num_rows($query)==0){
                //S'il n'existe pas d'etudiant dans la base de donnees ,alors on affiche ce message:
                echo "Il n'y a pas d'etudiant ajoute!";
            }
            else{
                //si non ,affichons la liste de tous les etudiants
                while($row=mysqli_fetch_assoc($query)){
                   ?>
                   <tr>
                       <td><?=$row["matricule"]?></td>
                       <td><?=$row["Nom"]?></td>
                       <td><?=$row["Prenoms"]?></td>
                       <td><?=$row["niveau"]?></td>
                       <td><?=$row["parcours"]?></td>
                       <td><?=$row["adr_mail"]?></td>
                       <td><a href="modifier.php?matricule=<?=$row['matricule']?>"><img src="image/modifier.jpg" alt=""></a></td>
                       <td><a href="supprimer.php?matricule=<?=$row['matricule']?>"><img src="image/suppre.png" alt=""></a></td>
                   </tr>
                  <?php
                }
            }
            ?>