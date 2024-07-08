<?php
session_start();
require_once './dbconnect.php';
    $sql = $_POST['sql'];

 mysqli_query($conn, $sql);

?>
