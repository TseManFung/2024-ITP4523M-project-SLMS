<?php
session_start();
require_once '../db/dbconnect.php';

$orderID = $_POST['orderID'];
$state = $_POST['state'];
$sql;
if (isset($_POST['deliveryDate'])) {
    $sql = "UPDATE `order` SET `state` = '$state', `salesManagerID` = {$_SESSION['salesManagerID']}, `deliveryDate` = '{$_POST['deliveryDate']}' WHERE `orderID` = $orderID;";
} else {
    $sql = "UPDATE `order` SET `state` = '$state', `salesManagerID` = {$_SESSION['salesManagerID']} WHERE `orderID` = $orderID;";
}
try {
    mysqli_query($conn, $sql);
} catch (Exception $e) {
    echo "sql error";
}
