<?php
require_once "../config/db.php";

if (isset($_GET['matricule'])) {
    $matricule = $_GET['matricule'];
    $stmt = mysqli_prepare($conn, "DELETE FROM soutenir WHERE matricule = ?");
    mysqli_stmt_bind_param($stmt, "s", $matricule);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header("Location: index.php");
exit();
?>
