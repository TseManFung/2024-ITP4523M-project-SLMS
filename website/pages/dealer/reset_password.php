<?php
session_start();
require_once '../db/dbconnect.php';

$sql = sprintf("UPDATE user 
                SET password ='%s'
                WHERE userID=%d"
                ,$_POST['hashedNewPW'],$_POST['UserID']);
mysqli_query($conn, $sql);
mysqli_close($conn);
?>
