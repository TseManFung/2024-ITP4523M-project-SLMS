<?php
session_start();
require_once '../db/dbconnect.php';
/*
    data: {
      sparePartNum: itemID,
      quantity: 1
    }

    */
    $sql = sprintf("INSERT INTO cart (userID, sparePartNum, qty)
            VALUES (%d, '%s', %d)
            ON DUPLICATE KEY UPDATE qty = qty + 1", $_SESSION['userID'], $_POST['sparePartNum'], $_POST['qty']);
 mysqli_query($conn, $sql);

?>