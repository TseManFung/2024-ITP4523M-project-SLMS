<?php
session_start();
require_once '../db/dbconnect.php';

$sql = sprintf("UPDATE cart 
                SET qty ='%d'
                WHERE sparePartNum=%s"
                ,$_POST['qty'],$_POST['sparePartNum']);
mysqli_query($conn, $sql);
mysqli_close($conn);
?>


