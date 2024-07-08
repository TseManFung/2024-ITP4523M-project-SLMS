<?php
session_start();
require_once './dbconnect.php';
    $sql = $_POST['query'];

 mysqli_query($conn, $sql);

?>
