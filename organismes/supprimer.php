<?php
require_once "../config/db.php";

if (isset($_GET['idorg'])) {
    $idorg = $_GET['idorg'];
    $stmt = mysqli_prepare($conn, "DELETE FROM organisme WHERE idorg = ?");
    mysqli_stmt_bind_param($stmt, "i", $idorg);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header("Location: index.php");
exit();
?>
