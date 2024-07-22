<?php
session_start();
require_once './dbconnect.php';
if (!isset($_POST['query'])) {
    echo "No query";
    exit;
}
$sql = $_POST['query'];
try {
    mysqli_multi_query($conn, $sql);
} catch (Exception $e) {
    echo "sql error";
}
