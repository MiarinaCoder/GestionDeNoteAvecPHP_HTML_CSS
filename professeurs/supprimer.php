<?php
require_once "../config/db.php";

if (isset($_GET['idprof'])) {
    $idprof = $_GET['idprof'];
    $stmt = mysqli_prepare($conn, "DELETE FROM professeur WHERE idprof = ?");
    mysqli_stmt_bind_param($stmt, "s", $idprof);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header("Location: index.php");
exit();
?>
