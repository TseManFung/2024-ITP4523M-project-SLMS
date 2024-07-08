<?php
session_start();
require_once '../db/dbconnect.php';

$sql = sprintf("UPDATE dealer 
                SET contactName='%s',contactNumber='%s', faxNumber='%s', deliveryAddress='%s' 
                WHERE dealerID=%d"
                ,$_POST['contactName'],$_POST['contactNumber'], $_POST['faxNumber'], $_POST['deliveryAddress'], $_POST['dealerID']);
mysqli_query($conn, $sql);
?>
