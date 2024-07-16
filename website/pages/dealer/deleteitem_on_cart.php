<?php
session_start();
require_once '../db/dbconnect.php';
/*
    data: {
      sparePartNum: itemID,
      quantity: 1
    }

    */
    $sql = sprintf(
        "DELETE FROM cart 
        WHERE userId = '%s' 
        AND sparePartNum = '%s'", $_SESSION['userID'], $_POST['sparePartNum']);
    mysqli_query($conn, $sql);
    
?>