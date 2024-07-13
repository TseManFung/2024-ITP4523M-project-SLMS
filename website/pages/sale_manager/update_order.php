<?php
session_start();
require_once '../db/dbconnect.php';

$orderID = $_POST['orderID'];
$state = $_POST['state'];
$sql="UPDATE `order` SET `state` = '$state', `salesManagerID` = {$_SESSION['salesManagerID']} WHERE `orderID` = $orderID;";
try {
    mysqli_query($conn, $sql);
} catch (Exception $e) {
    echo "sql error";
}
