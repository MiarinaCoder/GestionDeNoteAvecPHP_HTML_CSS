<?php
// Connexion à la base de données MySQL
$conn = mysqli_connect('localhost', 'root', '', 'gestion_soutenance');

// Vérifier la connexion
if (!$conn) {
    die("Connexion échouée: " . mysqli_connect_error());
}

// Récupérer la liste de tous les niveaux
$sql = "SELECT DISTINCT niveau FROM etudiant";
$result = mysqli_query($conn, $sql);

// Afficher la liste des niveaux sous forme de menu déroulant
echo "<form action='' method='post'>";
echo "<select name='niveau'>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row['niveau'] . "'>" . $row['niveau'] . "</option>";
}
echo "</select>";
echo "<input type='submit' name='submit' value='Afficher les étudiants'>";
echo "</form>";

// Récupérer les données des étudiants en fonction du niveau sélectionné
if (isset($_POST['submit'])) {
    $niveau = $_POST['niveau'];
    $sql = "SELECT * FROM etudiant WHERE niveau='$niveau'";
    $result = mysqli_query($conn, $sql);

    // Afficher les données des étudiants
    echo "<table>";
    echo "<tr><th>Nom</th><th>Prénom</th><th>Niveau</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row['Nom'] . "</td><td>" . $row['Prenoms'] . "</td><td>" . $row['niveau'] . "</td></tr>";
    }
    echo "</table>";
}

// Fermer la connexion à la base de données MySQL
mysqli_close($conn);
?>
