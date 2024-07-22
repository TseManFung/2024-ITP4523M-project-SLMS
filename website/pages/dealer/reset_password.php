<?php
session_start();
require_once '../db/dbconnect.php';

$sql = "UPDATE user 
        SET password = CONCAT('0', SHA2(?, 256))
        WHERE userID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "si", $_POST['hashedNewPW'], $_POST['UserID']);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
?>
